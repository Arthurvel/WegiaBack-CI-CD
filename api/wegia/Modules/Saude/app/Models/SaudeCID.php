<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;

class SaudeCID extends BaseModel
{

    protected $table = 'saude_tabelacid';

    protected $primaryKey = 'id_CID';

    protected $fillable = [
        'CID',
        'descricao'
    ];
}
