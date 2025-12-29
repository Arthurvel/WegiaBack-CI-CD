<?php

namespace Modules\ContribuicaoSocios\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContribuicaoLog extends BaseModel
{
    protected $table = 'contribuicao_log';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_socio',
        'id_gateway',
        'id_meio_pagamento',
        'codigo',
        'valor',
        'data_geracao',
        'data_vencimento',
        'data_pagamento',
        'status_pagamento',
        'url'
    ];

    public function socio() : BelongsTo
    {
        return $this->belongsTo(Socio::class, 'id_socio');
    }

    public function gateway() : BelongsTo
    {
        return $this->belongsTo(ContribuicaoGatewayPagamento::class, 'id_gateway');
    }

    public function meioPagamento() : BelongsTo
    {
        return $this->belongsTo(ContribuicaoMeioDePagamento::class, 'id_meio_pagamento');
    }
}
