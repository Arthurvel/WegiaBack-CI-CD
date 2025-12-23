<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\Services\Base\BaseService;
use Modules\ContribuicaoSocios\app\DTO\ContribuicaoBuscarTodosParamsDTO;
use Modules\ContribuicaoSocios\app\Repositories\ContribuicaoLogRepository;

class ContribuicaoLogService extends BaseService
{

    public function __construct
    (
        ContribuicaoLogRepository $repository,
    )
    {
        parent::__construct($repository);
    }


    public function buscarTodasPaginado(ContribuicaoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodasPaginado($dto);
    }

    public function atualizarPagamento(string $codigo)
    {
        return $this->repository->atualizarPagamento($codigo);
    }


}
