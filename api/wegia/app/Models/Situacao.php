<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;

class Situacao extends BaseModel
{

    protected $table = 'situacao';

    protected $primaryKey = 'id_situacao';

    public $timestamps = false;

    public function funcionario()
    {
        return $this->hasMany(Funcionario::class, 'id_situacao');
    }

}
