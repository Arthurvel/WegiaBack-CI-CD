<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeFichaMedicaParamsDTO;
use Modules\Saude\app\Repositories\SaudeFichaMedicaRepository;

class SaudeFichaMedicaService extends BaseService
{

    public function __construct
    (
        SaudeFichaMedicaRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarFichaMedica(SaudeFichaMedicaParamsDTO $dto)
    {
        return $this->repository->buscarFichaMedica($dto);
    }

}
