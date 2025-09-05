<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\DTO\PetBuscarTodosDTO;
use Modules\Pet\app\Models\Pet;

class PetRepository extends BaseRepository
{

    public function __construct(
        Pet $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(PetBuscarTodosDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;

        return $this->model
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('nome', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

}
