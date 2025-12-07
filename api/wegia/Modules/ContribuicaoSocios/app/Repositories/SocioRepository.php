<?php

namespace Modules\ContribuicaoSocios\app\Repositories;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Repositories\Base\BaseRepository;
use Modules\ContribuicaoSocios\app\Models\Socio;

class SocioRepository extends BaseRepository
{

    public function __construct(
        Socio $model
    )
    {
        parent::__construct($model);
    }

    private function buscarTodosPaginadoSemExecutado(PaginacaoFiltrosDTO $dto)
    {
        $buscar        = $dto->buscar ?? null;
        $ordenacao     = $dto->ordenacao ?? null;
        $tipoOrdenacao = $dto->tipoOrdenacao ?? 'ASC';

        return $this->model
            ->with(['pessoa', 'socioStatus', 'socioTipo', 'socioTag'])

            ->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($query) use ($buscar) {
                    $query->whereHas('pessoa', function ($p) use ($buscar) {
                        $p->where('nome', 'like', "%{$buscar}%");
                    })

                    ->orWhereHas('socioStatus', function ($s) use ($buscar) {
                        $s->where('descricao', 'like', "%{$buscar}%");
                    })

                    ->orWhereHas('socioTipo', function ($t) use ($buscar) {
                        $t->where('descricao', 'like', "%{$buscar}%");
                    })

                    ->orWhereHas('socioTag', function ($tag) use ($buscar) {
                        $tag->where('tag', 'like', "%{$buscar}%");
                    });
                });
            })

            ->when($ordenacao, function ($q) use ($ordenacao, $tipoOrdenacao) {

                if (in_array($ordenacao, ['nome', 'cpf'])) {
                    $q->join('pessoa', 'pessoa.id_pessoa', '=', 'socio.id_pessoa')
                        ->orderBy("pessoa.$ordenacao", $tipoOrdenacao)
                        ->select('socio.*');
                } else {
                    $q->orderBy($ordenacao, $tipoOrdenacao);
                }
            });
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;

        $paginado = $this->buscarTodosPaginadoSemExecutado($dto);

        return $paginado->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarTodosAniversariantesMesPaginado(PaginacaoFiltrosDTO $dto)
    {
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $mes             = now()->month;

        $paginado = $this->buscarTodosPaginadoSemExecutado($dto)
            ->whereHas('pessoa', function ($q) {
                $q->whereMonth('data_nascimento', now()->month);
            });


        return $paginado->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }


}
