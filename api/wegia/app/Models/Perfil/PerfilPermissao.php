<?php

namespace App\Models\Perfil;

use App\Models\BaseModel\BaseModel;

class PerfilPermissao extends BaseModel
{

    protected $table = 'perfil_permissao';

    protected $fillable = [
        'id_perfil',
        'id_permissao'
    ];

    public $timestamps = false;
}
