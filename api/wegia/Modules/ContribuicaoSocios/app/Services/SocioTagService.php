<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Services\Base\BaseService;
use Modules\ContribuicaoSocios\app\Repositories\SocioTagRepository;

class SocioTagService extends BaseService
{

    public function __construct
    (
        SocioTagRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

}
