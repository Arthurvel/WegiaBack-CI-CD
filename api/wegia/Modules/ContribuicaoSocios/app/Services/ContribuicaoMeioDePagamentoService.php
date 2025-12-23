<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\DTOs\PaginacaoFiltrosDTO;
use App\Services\Base\BaseService;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoMeioDePagamentoRepository;

class ContribuicaoMeioDePagamentoService extends BaseService
{

    public function __construct
    (
        ContribuicaoMeioDePagamentoRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

    public function buscarMeioPagamentosAtivos()
    {
        return $this->repository->buscarMeioPagamentosAtivos();
    }

}
