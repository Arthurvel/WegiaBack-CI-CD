<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;

class Almoxarifado extends BaseModel
{
    protected $table = 'material_almoxarifado';

    protected $primaryKey = 'id_almoxarifado';

    protected $fillable = [
        'descricao'
    ];
}

