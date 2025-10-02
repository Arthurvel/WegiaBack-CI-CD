<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeSinaisVitaisBuscarTodosParamsDTO;
use Modules\Saude\app\Repositories\SaudeSinaisVitaisRespository;

class SaudeSinaisVitaisService extends BaseService
{

    public function __construct
    (
        SaudeSinaisVitaisRespository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(SaudeSinaisVitaisBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }


}

