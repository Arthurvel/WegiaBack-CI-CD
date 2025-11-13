<?php

namespace Modules\ContribuicaoSocios\app\Repositories;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Repositories\Base\BaseRepository;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoConjuntoRegras;

class ContribuicaoConjuntoRegrasRepository extends BaseRepository
{

    public function __construct(
        ContribuicaoConjuntoRegras $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? 'id';
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;

        $query = $this->model
            ->with(['meioPagamento', 'regra'])
            ->when($buscar, function ($q) use ($buscar) {
                $q->where(function ($sub) use ($buscar) {
                    $sub->where('valor', 'like', "%{$buscar}%")
                        ->orWhereHas('meioPagamento', fn($mq) =>
                        $mq->where('meio', 'like', "%{$buscar}%")
                        )
                        ->orWhereHas('regra', fn($rq) =>
                        $rq->where('regra', 'like', "%{$buscar}%")
                        );
                });
            });

        switch ($ordenacao) {
            case 'meio':
                $query->orderByRaw("
                    (SELECT meio
                     FROM contribuicao_meioPagamento
                     WHERE contribuicao_meioPagamento.id = contribuicao_conjuntoRegras.id_meioPagamento)
                     {$tipoOrdenacao}
                ");
                break;

            case 'regra':
                $query->orderByRaw("
                    (SELECT regra
                     FROM contribuicao_regras
                     WHERE contribuicao_regras.id = contribuicao_conjuntoRegras.id_regra)
                     {$tipoOrdenacao}
                ");
                break;

            default:
                $query->orderBy($ordenacao, $tipoOrdenacao);
                break;
        }

        return $query->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

}
