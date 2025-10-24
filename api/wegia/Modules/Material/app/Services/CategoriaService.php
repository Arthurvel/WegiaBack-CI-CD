<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Modules\Material\app\DTO\CategoriaBuscarTodosParamsDTO;
use Modules\Material\app\Repositories\CategoriaRepository;

class CategoriaService extends BaseService
{

    public function __construct
    (
        CategoriaRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(CategoriaBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

}
