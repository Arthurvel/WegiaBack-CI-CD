<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;

class TipoMovimentacao extends BaseModel
{

    protected $table = 'material_tipo_movimentacao';

    protected $primaryKey = 'id_tipo_movimentacao';

    protected $fillable = [
        'nome',
        'tipo'
    ];

}
