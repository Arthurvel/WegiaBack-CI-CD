<?php

namespace Modules\ContribuicaoSocios\app\Models;

use App\Models\BaseModel\BaseModel;

class ContribuicaoRecorrencia extends BaseModel
{

    protected $table = 'recorrencia';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_socio',
        'id_gateway',
        'codigo',
        'valor',
        'data_inicio',
        'data_termino',
        'status'
    ];

}
