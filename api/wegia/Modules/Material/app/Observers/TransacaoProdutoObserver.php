<?php

namespace Modules\Material\app\Observers;

use Illuminate\Support\Facades\Auth;
use Modules\Material\app\Models\TransacaoProduto;
use Modules\Material\app\Models\TransacaoProdutoLog;

class TransacaoProdutoObserver
{
    public function updated(TransacaoProduto $produto)
    {
        TransacaoProdutoLog::create([
            'id_transacao_produto' => $produto->id_transacao_produto,
            'id_transacao' => $produto->id_transacao,
            'id_produto' => $produto->id_produto,
            'quantidade' => $produto->quantidade,
            'valor_unitario' => $produto->valor_unitario,
            'id_usuario_acao' => Auth::id(),
            'acao' => 'update',
        ]);
    }

    public function deleting(TransacaoProduto $produto)
    {
        TransacaoProdutoLog::create([
            'id_transacao_produto' => $produto->id_transacao_produto,
            'id_transacao' => $produto->id_transacao,
            'id_produto' => $produto->id_produto,
            'quantidade' => $produto->quantidade,
            'valor_unitario' => $produto->valor_unitario,
            'id_usuario_acao' => Auth::id(),
            'acao' => 'delete',
        ]);
    }

}
