<?php

namespace Modules\ContribuicaoSocios\app\Models;

use App\Models\BaseModel\BaseModel;

class ContribuicaoGatewayPagamento extends BaseModel
{
    protected $table = 'contribuicao_gatewayPagamento';

    protected $primaryKey = 'id';

    protected $fillable = [
        'plataforma',
        'endPoint',
        'token',
        'status'
    ];


}

