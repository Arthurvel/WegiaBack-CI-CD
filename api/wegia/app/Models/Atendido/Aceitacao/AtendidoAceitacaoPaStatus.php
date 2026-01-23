<?php

namespace App\Models\Atendido\Aceitacao;

use App\Models\BaseModel\BaseModel;

class AtendidoAceitacaoPaStatus extends BaseModel
{
    protected $table = 'pa_status';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'descricao'
    ];
}
