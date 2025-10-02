<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeAlergiaBuscarTodosParamsDTO;
use Modules\Saude\app\Repositories\SaudeAlergiaRepository;

class SaudeAlergiaService extends BaseService
{

    public function __construct
    (
        SaudeAlergiaRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosSemOsCadastrados(SaudeAlergiaBuscarTodosParamsDTO $dto)
    {
            return $this->repository->buscarTodosSemOsCadastrados($dto);
    }
}
