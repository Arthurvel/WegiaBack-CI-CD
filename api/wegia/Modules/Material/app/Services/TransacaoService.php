<?php

namespace Modules\Material\app\Services;

use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Material\app\DTO\TransacaoBuscarTodosParamsDTO;
use Modules\Material\app\DTO\TransacaoCadastrarDTO;
use Modules\Material\app\DTO\TransacaoProdutoCadastrarDTO;
use Modules\Material\app\Repositories\TransacaoProdutoRepository;
use Modules\Material\app\Repositories\TransacaoRepository;

class TransacaoService extends BaseService
{

    protected TransacaoProdutoRepository $transacaoProdutoRepository;

    public function __construct
    (
        TransacaoRepository $repository,
        TransacaoProdutoRepository $transacaoProdutoRepository
    )
    {
        parent::__construct($repository);
        $this->transacaoProdutoRepository = $transacaoProdutoRepository;
    }

    public function buscarTodosPaginado(TransacaoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

    public function criarTransacaoComProduto(TransacaoCadastrarDTO $transacaoCadastrarDTO, array $produtos)
    {
        return DB::transaction(function () use ($transacaoCadastrarDTO, $produtos) {

            $transacao = $this->repository->criar($transacaoCadastrarDTO);

            $produtosDTO = array_map(function ($produto) use ($transacao) {
                return TransacaoProdutoCadastrarDTO::fromArray([
                    'id_transacao'   => $transacao->id_transacao,
                    'id_produto'     => $produto['id_produto'],
                    'quantidade'     => $produto['quantidade'],
                    'valor_unitario' => $produto['valor_unitario'],
                ]);
            }, $produtos);

            $this->transacaoProdutoRepository->criarEmMassa($produtosDTO);

            return $transacao;
        });
    }
}

