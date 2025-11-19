<?php

namespace Modules\Material\app\Models;

use App\Models\BaseModel\BaseModel;

class Unidade extends BaseModel
{

    protected $table = 'material_unidade';

    protected $primaryKey = 'id_unidade';

    protected $fillable = [
        'descricao'
    ];

}
