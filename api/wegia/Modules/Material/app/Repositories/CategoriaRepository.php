<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\DTO\CategoriaBuscarTodosParamsDTO;
use Modules\Material\app\Models\Categoria;

class CategoriaRepository extends BaseRepository
{

    public function __construct(
        Categoria $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(CategoriaBuscarTodosParamsDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $status          = $dto->status ?? null;

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
