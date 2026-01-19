<?php

namespace Modules\ContribuicaoSocios\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoBuscarComprovantePagamentoPorPeriodoDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoBuscarTodosParamsDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoLogAtualizarVariosPagamentosDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoLogCadastrarDTO;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoLogCriarVariasRecorrenciasDTO;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoLog;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoRecorrencia;

class ContribuicaoLogRepository extends BaseRepository
{

    private ContribuicaoRecorrencia $recorrenciaModel;

    public function __construct(
        ContribuicaoLog $model,
        ContribuicaoRecorrencia $recorrenciaModel
    )
    {
        parent::__construct($model);
        $this->recorrenciaModel = $recorrenciaModel;
    }

    public function buscarTodasPaginado(ContribuicaoBuscarTodosParamsDTO $dto)
    {

        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $periodo         = $dto->periodo ?? null;
        $id_socio        = $dto->id_socio ?? null;
        $status          = $dto->status ?? null;
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;

        return $this->model
            ->with(['socio.pessoa', 'gateway', 'meioPagamento'])
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('socio.pessoa', function ($s) use ($buscar) {
                    $s->where('nome', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if ($ordenacao == 'nome') {
                    return $q->join('socio', 'contribuicao_log.id_socio', '=', 'socio.id_socio')
                        ->join('pessoa', 'socio.id_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy('pessoa.nome', $tipoOrdenacao)
                        ->select('contribuicao_log.*');
                }

                if ($ordenacao == 'plataforma') {
                    return $q->join('contribuicao_gatewayPagamento', 'contribuicao_log.id_gateway', '=', 'contribuicao_gatewayPagamento.id')
                        ->orderBy('contribuicao_gatewayPagamento.plataforma', $tipoOrdenacao)
                        ->select('contribuicao_log.*');
                }

                if ($ordenacao == 'meio_pagamento') {
                    return $q->join('contribuicao_meioPagamento', 'contribuicao_log.id_meio_pagamento', '=', 'contribuicao_meioPagamento.id')
                        ->orderBy('contribuicao_meioPagamento.meio', $tipoOrdenacao)
                        ->select('contribuicao_log.*');
                }

                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->when(!is_null($id_socio), function ($q) use ($id_socio) {
                return $q->where('id_socio', $id_socio);
            })
            ->when(!is_null($status), function ($q) use ($status) {
                return $q->where('status_pagamento', $status);
            })
            ->when(!is_null($periodo), function ($q) use ($periodo) {
                $dataLimite = Carbon::now()->subDays($periodo);
                return $q->where('data_geracao', '>=', $dataLimite);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarContribuicoesSegundaVia(string $documento)
    {
        return $this->model
            ->select([
                'id',
                'id_socio',
                'data_vencimento',
                'data_geracao',
                'url'
            ])
            ->with([
                'socio:id_socio,id_pessoa',
                'socio.pessoa:id_pessoa,nome,cpf'
            ])
            ->whereHas('socio.pessoa', function ($s) use ($documento) {
                $s->where('cpf', $documento);
            })
            ->where('status_pagamento', '!=', '1')
            ->where(function ($q) {
                $q->whereNull('data_pagamento')
                    ->orWhere('data_pagamento', '');
            })
            ->whereNotNull('url')
            ->where('url', '!=', '')
            ->orderBy('data_vencimento', 'ASC')
            ->get();
    }

    public function buscarComprovantePagamentoPorPeriodo(ContribuicaoBuscarComprovantePagamentoPorPeriodoDTO $dto)
    {
        return $this->model
            ->with(['meioPagamento', 'socio.pessoa'])
            ->whereHas('socio.pessoa', function ($s) use ($dto) {
                $s->where('cpf', $dto->cpf_cnpj);
            })
            ->where('data_pagamento', '<=', $dto->data_fim)
            ->where('data_pagamento', '>=', $dto->data_inicio)
            ->get();
    }

    public function atualizarPagamento(string $codigo)
    {
        $log = $this->model->where('codigo', $codigo)->firstOrFail();

        return $log->update([
            'status_pagamento' => true,
            'data_pagamento'   => now(),
        ]);
    }

    /**
     * @param ContribuicaoLogAtualizarVariosPagamentosDTO[] $contribuicoesPagasDTO
     */
    public function atualizarVariosPagamentos(array $contribuicoesPagasDTO): int
    {
        return DB::transaction(function () use ($contribuicoesPagasDTO) {

            $atualizados = 0;

            collect($contribuicoesPagasDTO)
                ->chunk(200)
                ->each(function ($chunk) use (&$atualizados) {

                    $porData = $chunk->groupBy('data_pagamento');

                    foreach ($porData as $dataPagamento => $items) {
                        $codigos = $items->pluck('codigo')->toArray();

                        $atualizados += $this->model
                            ->whereIn('codigo', $codigos)
                            ->update([
                                'status_pagamento' => true,
                                'data_pagamento'   => $dataPagamento,
                            ]);
                    }
                });

            return $atualizados;
        });
    }

    /**
     * @param ContribuicaoLogCriarVariasRecorrenciasDTO[] $contribuicoesCriarVariasRecorrenciasDTO
     */
    public function criarAPartirDeRecorrencia(array $contribuicoesCriarVariasRecorrenciasDTO): int
    {
        return DB::transaction(function () use ($contribuicoesCriarVariasRecorrenciasDTO) {

            $collection = collect($contribuicoesCriarVariasRecorrenciasDTO);

            $codigosExistentes = $this->model
                ->whereIn('codigo', $collection->pluck('codigo'))
                ->pluck('codigo')
                ->toArray();

            $novos = $collection->filter(fn($dto) => !in_array($dto->codigo, $codigosExistentes));

            if ($novos->isEmpty()) {
                return 0;
            }

            $codigosRecorrencia = $novos->pluck('codigo_recorrencia')->unique();
            $recorrencias = $this->recorrenciaModel::whereIn('codigo', $codigosRecorrencia)
                ->get()
                ->keyBy('codigo');

            $dadosParaInserir = [];

            foreach ($novos as $dto) {
                $recorrencia = $recorrencias->get($dto->codigo_recorrencia);

                if (!$recorrencia) {
                    continue;
                }

                $dadosParaInserir[] = ContribuicaoLogCadastrarDTO::fromArray([
                    'id_socio'          => $recorrencia->id_socio,
                    'id_gateway'        => $recorrencia->id_gateway,
                    'id_meio_pagamento' => 5,
                    'id_recorrencia'    => $recorrencia->id,
                    'codigo'            => $dto->codigo,
                    'valor'             => $recorrencia->valor,
                    'data_geracao'      => $dto->data_geracao,
                    'data_vencimento'   => $dto->data_vencimento,
                    'status_pagamento'  => $dto->status_pagamento ,
                    'data_pagamento'    => $dto->data_pagamento
                ]);
            }

            $criados = 0;
            foreach (array_chunk($dadosParaInserir, 500) as $chunk) {
                $this->criarEmMassa($chunk);
            }

            return $criados;
        });
    }


}
