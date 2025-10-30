<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Modules\Material\app\DTO\ParceiroBuscarTodosParamsDTO;
use Modules\Material\app\Repositories\ParceiroRepository;

class ParceiroService extends BaseService
{

    public function __construct
    (
        ParceiroRepository $repository,
    )
    {
        parent::__construct($repository);
    }
    public function buscarTodosPaginado(ParceiroBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }
}
