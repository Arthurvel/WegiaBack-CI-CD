<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Modules\Material\app\DTO\TipoMovimentacaoBuscarTodosParamsDTO;
use Modules\Material\app\DTO\TipoMovimentacaoBuscarTodosSemPaginacaoParamsDTO;
use Modules\Material\app\Repositories\TipoMovimentacaoRepository;

class TipoMovimentacaoService extends BaseService
{

    public function __construct
    (
        TipoMovimentacaoRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosFiltro(TipoMovimentacaoBuscarTodosSemPaginacaoParamsDTO $dto)
    {
        return $this->repository->buscarTodosFiltro($dto);
    }

    public function buscarTodosPaginado(TipoMovimentacaoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }
}
