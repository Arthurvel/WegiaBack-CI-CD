<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Funcionario\Funcionario;

class Cargo extends BaseModel
{

    protected $table = 'cargo';

    protected $primaryKey = 'id_cargo';

    protected $fillable = [
        'cargo'
    ];

    public $timestamps = false;

    public function funcionario()
    {
        return $this->hasMany(Funcionario::class, 'id_cargo');
    }

}
