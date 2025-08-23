<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\DTO\MedicamentoBuscarTodosDTO;
use Modules\Pet\app\Models\Medicamento;

class MedicamentoRepository extends BaseRepository
{
    public function __construct(
        Medicamento $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(MedicamentoBuscarTodosDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;

        return $this->model
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('nome_medicamento', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }


    public function buscarTodos()
    {
        return $this->model
            ->select(['id_medicamento', 'nome_medicamento'])
            ->get();
    }

}
