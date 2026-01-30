<?php

namespace Modules\ContribuicaoSocios\app\Repositories;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Repositories\Base\BaseRepository;
use Modules\ContribuicaoSocios\app\DTO\SocioRelatorioBuscarTodosParamsDTO;
use Modules\ContribuicaoSocios\app\Models\Socio;
use Modules\ContribuicaoSocios\app\Models\SocioTipo;

class SocioRepository extends BaseRepository
{

    private SocioTipo $socioTipo;

    public function __construct(
        Socio $model,
        SocioTipo $socioTipo
    )
    {
        parent::__construct($model);
        $this->socioTipo = $socioTipo;
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina = $dto->pagina ?? 1;

        $paginado = $this->buscarTodosPaginadoSemExecutado($dto);

        return $paginado->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarTodosAniversariantesMesPaginado(PaginacaoFiltrosDTO $dto)
    {
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina = $dto->pagina ?? 1;
        $mes = now()->month;

        $paginado = $this->buscarTodosPaginadoSemExecutado($dto)
            ->whereHas('pessoa', function ($q) {
                $q->whereMonth('data_nascimento', now()->month);
            });


        return $paginado->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarSocioRelatorio(SocioRelatorioBuscarTodosParamsDTO $dto)
    {
        $tipo_socio = $dto->tipo_socio ?? null;
        $id_status = $dto->id_status ?? null;
        $id_tag = $dto->id_tag ?? null;
        $tipo_pessoa = $dto->tipo_pessoa ?? null;
        $valor_filtro = $dto->valor_filtro ?? 'maior';
        $valor = $dto->valor ?? 0;

        $operatorMap = [
            'maior' => '>',
            'maior_igual' => '>=',
            'igual' => '=',
            'menor_igual' => '<=',
            'menor' => '<'
        ];
        $op = $operatorMap[$valor_filtro] ?? null;

        $tipo_completo = null;
        if ($tipo_pessoa || $tipo_socio) {
            $tipo_pessoa_texto = null;
            if ($tipo_pessoa) {
                $tipo_pessoa_texto = strtolower($tipo_pessoa) === 'f' ? 'Física' : 'Jurídica';
            }

            $partes = array_filter([$tipo_pessoa_texto, $tipo_socio]);
            $tipo_completo = '%' . implode(' - ', $partes) . '%';
        }

        return $this->model
            ->with(['pessoa', 'socioStatus', 'socioTipo', 'socioTag'])
            ->when($id_status, function ($q) use ($id_status) {
                return $q->whereHas('socioStatus', function ($s) use ($id_status) {
                    $s->where('id_socioStatus', $id_status);
                });
            })
            ->when($id_tag, function ($q) use ($id_tag) {
                return $q->whereHas('socioTag', function ($s) use ($id_tag) {
                    $s->where('id_socioTag', $id_tag);
                });
            })
            ->when($tipo_completo, function ($q) use ($tipo_completo) {
                return $q->whereHas('socioTipo', function ($s) use ($tipo_completo) {
                    $s->whereRaw('LOWER(tipo) LIKE LOWER(?)', [$tipo_completo]);
                });
            })
            ->when($op, function ($q) use ($op, $valor) {
                $q->where('valor_periodo', $op, $valor);
            })
            ->get();
    }

    public function buscarEstatisticasComTipoSocio()
    {
        return $this->socioTipo
            ->leftJoin('socio', 'socio_tipo.id_sociotipo', '=', 'socio.id_sociotipo')
            ->selectRaw("
                TRIM(
                    SUBSTRING_INDEX(
                        SUBSTRING_INDEX(socio_tipo.tipo, '-', 2),
                        '-',
                        -1
                    )
                ) as tipo_intermediario,
                COUNT(socio.id_socio) as total_socios
            ")
            ->groupBy('tipo_intermediario')
            ->orderBy('total_socios', 'DESC')
            ->get();
    }

    private function buscarTodosPaginadoSemExecutado(PaginacaoFiltrosDTO $dto)
    {
        $buscar = $dto->buscar ?? null;
        $ordenacao = $dto->ordenacao ?? null;
        $tipoOrdenacao = $dto->tipoOrdenacao ?? 'ASC';

        return $this->model
            ->with(['pessoa', 'socioStatus', 'socioTipo', 'socioTag'])
            ->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($query) use ($buscar) {
                    $query->whereHas('pessoa', function ($p) use ($buscar) {
                        $p->where('nome', 'like', "%{$buscar}%");
                    })
                        ->orWhereHas('socioStatus', function ($s) use ($buscar) {
                            $s->where('status', 'like', "%{$buscar}%");
                        })
                        ->orWhereHas('socioTipo', function ($t) use ($buscar) {
                            $t->where('tipo', 'like', "%{$buscar}%");
                        })
                        ->orWhereHas('socioTag', function ($tag) use ($buscar) {
                            $tag->where('tag', 'like', "%{$buscar}%");
                        });
                });
            })
            ->when($ordenacao, function ($q) use ($ordenacao, $tipoOrdenacao) {

                if (in_array($ordenacao, ['nome', 'cpf', 'data_nascimento'])) {
                    $q->join('pessoa', 'pessoa.id_pessoa', '=', 'socio.id_pessoa')
                        ->orderBy("pessoa.$ordenacao", $tipoOrdenacao)
                        ->select('socio.*');
                } else {
                    $q->orderBy($ordenacao, $tipoOrdenacao);
                }
            });
    }
}
