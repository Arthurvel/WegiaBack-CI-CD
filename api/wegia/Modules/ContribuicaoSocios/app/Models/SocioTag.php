<?php

namespace Modules\ContribuicaoSocios\app\Models;

use App\Models\BaseModel\BaseModel;

class SocioTag extends BaseModel
{

    protected $table = 'socio_tag';

    protected $primaryKey = 'id_sociotag';

    protected $fillable = [
        'tag'
    ];

}
