<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;

class Origem extends BaseModel
{
    protected $table = 'origem';

    protected $primaryKey = 'id_origem';

    protected $fillable = [
        'nome_origem',
        'cnpj',
        'cpf',
        'telefone'
    ];
}

