<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;

class SaudeFichaMedicaProntuarioHistorico extends BaseModel
{

    protected $table = 'saude_fichamedica_prontuario_historico';

    protected $primaryKey = 'id_prontuario_historico';

    protected $fillable = [
        'id_fichamedica',
        'prontuario',
        'data'
    ];

}
