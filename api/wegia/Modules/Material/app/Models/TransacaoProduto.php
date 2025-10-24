<?php

namespace Modules\Material\app\Models;

use Illuminate\Database\Eloquent\Model;

class TransacaoProduto extends Model
{

    protected $table = 'material_transacao_produto';

    protected $primaryKey = 'id_transacao_produto';

    protected $fillable = [
        'id_transacao',
        'id_produto',
        'quantidade',
        'valor_unitario'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }

    public function transacao()
    {
        return $this->belongsTo(Transacao::class, 'id_transacao', 'id_transacao');
    }

}
