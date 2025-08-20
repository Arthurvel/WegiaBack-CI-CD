<?php

namespace App\Services;

use App\DTOs\Aviso\AvisoBuscarTodosParamsDTO;
use App\Repositories\AvisoRepository;
use App\Services\Base\BaseService;

class AvisoService extends BaseService
{
    public function __construct(AvisoRepository $repository)
    {
        parent::__construct($repository);
    }

    public function buscarTodosFiltro(AvisoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosFiltro($dto);
    }

    public function desativar(int $id)
    {
        return $this->repository->desativar($id);
    }
}
