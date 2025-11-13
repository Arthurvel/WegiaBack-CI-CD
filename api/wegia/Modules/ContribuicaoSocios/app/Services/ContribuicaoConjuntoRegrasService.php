<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Services\Base\BaseService;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoConjuntoRegrasRepository;

class ContribuicaoConjuntoRegrasService extends BaseService
{

    public function __construct
    (
        ContribuicaoConjuntoRegrasRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }
}
