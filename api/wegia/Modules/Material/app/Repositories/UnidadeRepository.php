<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\DTO\UnidadeBuscarTodosParamsDTO;
use Modules\Material\app\Models\Unidade;

class UnidadeRepository extends BaseRepository
{

    public function __construct(
        Unidade $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(UnidadeBuscarTodosParamsDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;

        return $this->model
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('descricao', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy("$ordenacao", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
