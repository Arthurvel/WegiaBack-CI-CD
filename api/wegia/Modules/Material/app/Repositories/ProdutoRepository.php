<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\DTO\ProdutoBuscarTodosParamsDTO;
use Modules\Material\app\Models\Produto;

class ProdutoRepository extends BaseRepository
{

    public function __construct(
        Produto $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(ProdutoBuscarTodosParamsDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $status          = $dto->status ?? null;

        return $this->model
            ->with(['categoria', 'unidade'])
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('material_produto.descricao', 'like', "%{$buscar}%")
                    ->orWhere('material_produto.codigo', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                if($ordenacao == 'descricao_unidade') {
                    return $q->join('material_unidade', 'material_produto.id_unidade', '=', 'material_unidade.id_unidade')
                        ->orderBy("material_unidade.descricao", $tipoOrdenacao);
                } elseif ($ordenacao == 'descricao_categoria') {
                    return $q->join('material_categoria', 'material_produto.id_categoria', '=', 'material_categoria.id_categoria')
                        ->orderBy("material_categoria.descricao", $tipoOrdenacao);
                }

                return $q->orderBy("$ordenacao", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
