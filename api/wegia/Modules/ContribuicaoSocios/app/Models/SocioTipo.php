<?php

namespace Modules\ContribuicaoSocios\app\Models;

use App\Models\BaseModel\BaseModel;

class SocioTipo extends BaseModel
{

    protected $table = 'socio_tipo';

    protected $primaryKey = 'id_sociotipo';

    protected $fillable = [
        'tipo'
    ];

}
