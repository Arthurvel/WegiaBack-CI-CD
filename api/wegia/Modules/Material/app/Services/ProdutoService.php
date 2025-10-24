<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Modules\Material\app\DTO\ProdutoBuscarTodosParamsDTO;
use Modules\Material\app\Repositories\ProdutoRepository;

class ProdutoService extends BaseService
{

    public function __construct
    (
        ProdutoRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(ProdutoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }
}
