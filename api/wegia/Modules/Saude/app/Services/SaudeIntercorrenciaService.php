<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeIntercorrenciaBuscarTodosParamsDTO;
use Modules\Saude\app\Repositories\SaudeIntercorrenciaRepository;

class SaudeIntercorrenciaService extends BaseService
{

    public function __construct
    (
        SaudeIntercorrenciaRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(SaudeIntercorrenciaBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

}
