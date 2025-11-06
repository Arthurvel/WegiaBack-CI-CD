<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\DTO\AlmoxarifadoBuscarTodosParamsDTO;
use Modules\Material\app\Models\Almoxarifado;

class AlmoxarifadoRepository extends BaseRepository
{

    public function __construct(
        Almoxarifado $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginados(AlmoxarifadoBuscarTodosParamsDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;

        return $this->model
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('descricao_almoxarifado', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy("$ordenacao", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
