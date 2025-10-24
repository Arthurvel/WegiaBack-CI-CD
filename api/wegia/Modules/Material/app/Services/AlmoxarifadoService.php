<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Modules\Material\app\DTO\AlmoxarifadoBuscarTodosParamsDTO;
use Modules\Material\app\Repositories\AlmoxarifadoRepository;

class AlmoxarifadoService extends BaseService
{

    public function __construct
    (
        AlmoxarifadoRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginados(AlmoxarifadoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginados($dto);
    }

}
