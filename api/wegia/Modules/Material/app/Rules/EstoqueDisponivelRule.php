<?php

namespace Modules\Material\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Material\app\Repositories\TransacaoProdutoRepository;

class EstoqueDisponivelRule implements Rule
{
    private TransacaoProdutoRepository $transacaoProdutoRepository;
    private int $idAlmoxarifado;
    private string $tipoMovimentacao;
    private ?int $idProduto;
    private array $mensagensErro = [];

    public function __construct(
        TransacaoProdutoRepository $transacaoProdutoRepository,
        int $idAlmoxarifado,
        string $tipoMovimentacao,
        ?int $idProduto = null
    ) {
        $this->transacaoProdutoRepository = $transacaoProdutoRepository;
        $this->idAlmoxarifado = $idAlmoxarifado;
        $this->tipoMovimentacao = $tipoMovimentacao;
        $this->idProduto = $idProduto;
    }

    public function passes($attribute, $value)
    {
        if ($this->tipoMovimentacao !== 's') {
            return true;
        }

        if (is_numeric($value) && $this->idProduto) {
            return $this->validarProdutoIndividual($this->idProduto, $value);
        }

        if (is_array($value)) {
            return $this->validarListaDeProdutos($value);
        }

        $this->mensagensErro[] = "Formato de valor inválido para validação de estoque.";
        return false;
    }

    private function validarProdutoIndividual(int $idProduto, int $quantidade): bool
    {
        $estoques = $this->transacaoProdutoRepository
            ->obterEstoqueAtualPorProdutosEAlmoxarifado($this->idAlmoxarifado, [$idProduto]);

        $estoqueAtual = $estoques[0]->estoque ?? 0;
        $nomeProduto = $estoques[0]->nome_produto ?? "Produto {$idProduto}";

        if ($estoqueAtual - $quantidade < 0) {
            $this->mensagensErro[] =
                "Produto {$nomeProduto} sem estoque suficiente. Estoque atual: {$estoqueAtual}, tentativa: {$quantidade}.";
        }

        return empty($this->mensagensErro);
    }

    private function validarListaDeProdutos(array $produtos): bool
    {
        $idsProdutos = array_column($produtos, 'id_produto');
        $estoquesDetalhados = $this->transacaoProdutoRepository
            ->obterEstoqueAtualPorProdutosEAlmoxarifado($this->idAlmoxarifado, $idsProdutos);

        $estoques = [];
        foreach ($estoquesDetalhados as $item) {
            $estoques[$item->id_produto] = [
                'nome' => $item->nome_produto,
                'estoque' => $item->estoque,
            ];
        }

        foreach ($produtos as $produto) {
            $id = $produto['id_produto'];
            $qtd = $produto['quantidade'];
            $nome = $estoques[$id]['nome'] ?? "Produto {$id}";
            $estoqueAtual = $estoques[$id]['estoque'] ?? 0;

            if ($estoqueAtual - $qtd < 0) {
                $this->mensagensErro[] =
                    "Produto {$nome} sem estoque suficiente. Estoque atual: {$estoqueAtual}, tentativa: {$qtd}.";
            }
        }

        return empty($this->mensagensErro);
    }

    public function message()
    {
        return implode(PHP_EOL, $this->mensagensErro);
    }
}
