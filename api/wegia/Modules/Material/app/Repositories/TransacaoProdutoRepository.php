<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\Models\TransacaoProduto;
use Modules\Material\app\Models\Views\EstoqueAtualView;

class TransacaoProdutoRepository extends BaseRepository
{

    protected $estoqueAtualView;
    public function __construct(
        TransacaoProduto $model,
        EstoqueAtualView $estoqueAtualView
    )
    {
        parent::__construct($model);
        $this->estoqueAtualView = $estoqueAtualView;
    }

    public function obterEstoqueAtualPorProdutosEAlmoxarifado(int $idAlmoxarifado, array $idsProdutos)
    {

        return $this->estoqueAtualView
            ->where('id_almoxarifado', $idAlmoxarifado)
            ->whereIn('id_produto', $idsProdutos)
            ->get();
    }
}
