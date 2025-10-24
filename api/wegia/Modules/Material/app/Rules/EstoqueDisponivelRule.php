<?php

namespace Modules\Material\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Material\app\Repositories\TransacaoProdutoRepository;

class EstoqueDisponivelRule implements Rule
{

    private TransacaoProdutoRepository $transacaoProdutoRepository;
    private int $idAlmoxarifado;
    private string $tipoMovimentacao;
    private array $mensagensErro = [];


    public function __construct(
        TransacaoProdutoRepository $transacaoProdutoRepository,
        int $idAlmoxarifado,
        string $tipoMovimentacao
    )
    {
        $this->transacaoProdutoRepository = $transacaoProdutoRepository;
        $this->idAlmoxarifado = $idAlmoxarifado;
        $this->tipoMovimentacao = $tipoMovimentacao;
    }

    public function passes($attribute, $value)
    {
        if ($this->tipoMovimentacao !== 's') return true;

        $idsProdutos = array_column($value, 'id_produto');

        $estoquesDetalhados = $this->transacaoProdutoRepository->obterEstoqueAtualPorProdutosEAlmoxarifado(
            $this->idAlmoxarifado,
            $idsProdutos
        );

        $estoques = [];
        foreach ($estoquesDetalhados as $item) {
            $estoques[$item->id_produto] = [
                'nome' => $item->nome_produto,
                'estoque' => $item->estoque
            ];
        }

        foreach ($value as $produto) {
            $id = $produto['id_produto'];
            $qtd = $produto['quantidade'];
            $nome = $estoques[$id]['nome'] ?? "Produto {$id}";
            $estoqueAtual = $estoques[$id]['estoque'] ?? 0;

            if ($estoqueAtual - $qtd < 0) {
                $this->mensagensErro[] = "Produto {$nome} sem estoque suficiente no almoxarifado. Estoque atual: {$estoqueAtual}, tentativa de saída: {$qtd}.";
            }
        }

        return empty($this->mensagensErro);
    }

    public function message()
    {
        return implode(PHP_EOL, $this->mensagensErro);
    }

}
