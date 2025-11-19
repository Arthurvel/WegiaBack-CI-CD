<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeFichaMedicaAlergiaBuscarTodosParamsDTO;
use Modules\Saude\app\Repositories\SaudeFichaMedicaAlergiaRepository;

class SaudeFichaMedicaAlergiaService extends BaseService
{

    public function __construct
    (
        SaudeFichaMedicaAlergiaRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(SaudeFichaMedicaAlergiaBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }
}
