<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;

class TransacaoProdutoLog extends BaseModel
{
    protected $table = 'material_transacao_produto_logs';

    protected $primaryKey = 'id_transacao_produto_log';

    protected $fillable = [
        'id_transacao_produto',
        'id_transacao',
        'id_produto',
        'quantidade',
        'valor_unitario',
        'id_usuario_acao',
        'acao'
    ];
}
