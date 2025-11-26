<?php

namespace Modules\ContribuicaoSocios\app\Models;

use App\Models\BaseModel\BaseModel;

class SocioStatus extends BaseModel
{

    protected $table = 'socio_status';

    protected $primaryKey = 'id_sociostatus';

    protected $fillable = [
        'status'
    ];

}
