<?php

namespace Modules\ContribuicaoSocios\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContribuicaoMeioDePagamento extends BaseModel
{
    protected $table = 'contribuicao_meioPagamento';

    protected $primaryKey = 'id';

    protected $fillable = [
        'meio',
        'id_plataforma',
        'status'
    ];

    public function gateway() : BelongsTo
    {
        return $this->belongsTo(ContribuicaoGatewayPagamento::class, 'id_plataforma', 'id');
    }
}

