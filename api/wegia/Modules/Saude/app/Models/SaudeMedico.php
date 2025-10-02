<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;

class SaudeMedico extends BaseModel
{

    protected $table = 'saude_medicos';

    protected $primaryKey = 'id_medico';

    protected $fillable = [
        'crm',
        'nome'
    ];

}
