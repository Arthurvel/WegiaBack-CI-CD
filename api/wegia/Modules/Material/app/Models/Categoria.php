<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;

class Categoria extends BaseModel
{

    protected $table = 'material_categoria';

    protected $primaryKey = 'id_categoria';

    protected $fillable = [
        'descricao'
    ];

}
