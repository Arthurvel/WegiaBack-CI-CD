<?php

namespace App\Models\Funcionario\Perfil;

use App\Models\BaseModel\BaseModel;
use App\Models\Funcionario\Perfil\FuncionarioPermissao;
use App\Models\Funcionario\Funcionario;

class FuncionarioPerfil extends BaseModel
{

    protected $table = 'perfil';

    protected $primaryKey = 'id_perfil';

    protected $fillable = [
        'cargo',
        'nome'
    ];

    public $timestamps = false;

    public function permissoes()
    {
        return $this->belongsToMany(
            FuncionarioPermissao::class,
            'perfil_permissao',
            'id_perfil',
            'id_permissao'
        );
    }

    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class, 'id_perfil', 'id_perfil');
    }
}
