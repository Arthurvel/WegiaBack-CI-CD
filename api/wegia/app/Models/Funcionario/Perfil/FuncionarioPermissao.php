<?php

namespace App\Models\Funcionario\Perfil;

use App\Models\BaseModel\BaseModel;

class FuncionarioPermissao extends BaseModel
{

    protected $table = 'perfil_permissao';

    protected $fillable = [
        'id_perfil',
        'id_permissao'
    ];

    public $timestamps = false;
}
