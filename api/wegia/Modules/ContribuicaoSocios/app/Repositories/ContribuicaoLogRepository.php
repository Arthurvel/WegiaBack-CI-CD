<?php

namespace Modules\ContribuicaoSocios\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Carbon\Carbon;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoBuscarTodosParamsDTO;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoLog;

class ContribuicaoLogRepository extends BaseRepository
{

    public function __construct(
        ContribuicaoLog $model
    )
    {
        parent::__construct($model);
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

    public function atualizarPagamento(string $codigo)
    {
        $log = $this->model->where('codigo', $codigo)->firstOrFail();

        return $log->update([
            'status_pagamento' => true,
            'data_pagamento'   => now(),
        ]);
    }

}
