<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;

class Parceiro extends BaseModel
{

    protected $table = 'material_parceiro';

    protected $primaryKey = 'id_parceiro';

    protected $fillable = [
        'nome',
        'cpf',
        'cnpj',
        'telefone'
    ];

}
