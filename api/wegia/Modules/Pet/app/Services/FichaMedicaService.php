<?php

namespace Modules\Pet\app\Services;

use App\Services\Base\BaseService;
use Modules\Pet\app\DTO\FichaMedicaAtualizarDTO;
use Modules\Pet\app\Repositories\FichaMedicaRepository;
class FichaMedicaService extends BaseService
{
    public function __construct
    (
        FichaMedicaRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function atualizarPorPet(int $id, FichaMedicaAtualizarDTO $dto)
    {
        return $this->repository->atualizarPorPet($id, $dto);
    }
}
