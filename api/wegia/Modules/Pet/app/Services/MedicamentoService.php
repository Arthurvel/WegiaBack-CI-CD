<?php

namespace Modules\Pet\app\Services;

use App\Services\Base\BaseService;
use Modules\Pet\app\DTO\MedicamentoBuscarTodosDTO;
use Modules\Pet\app\Repositories\MedicamentoRepository;
class MedicamentoService extends BaseService
{
    public function __construct
    (
        MedicamentoRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(MedicamentoBuscarTodosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

}
