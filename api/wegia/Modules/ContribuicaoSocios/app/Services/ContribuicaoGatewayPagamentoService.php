<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Services\Base\BaseService;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoGatewayPagamentoRepository;

class ContribuicaoGatewayPagamentoService extends BaseService
{

    public function __construct
    (
        ContribuicaoGatewayPagamentoRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

}
