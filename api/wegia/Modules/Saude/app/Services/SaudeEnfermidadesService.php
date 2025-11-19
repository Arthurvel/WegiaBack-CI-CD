<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeEnfermidadeBuscarParamsDTO;
use Modules\Saude\app\Repositories\SaudeEnfermidadesRespository;

class SaudeEnfermidadesService extends BaseService
{
    public function __construct
    (
        SaudeEnfermidadesRespository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginacao(SaudeEnfermidadeBuscarParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginacao($dto);
    }


}
