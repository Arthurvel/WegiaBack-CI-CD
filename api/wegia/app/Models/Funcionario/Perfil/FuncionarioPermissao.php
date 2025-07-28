<?php

namespace App\Models\Funcionario\Perfil;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Funcionario\Perfil\FuncionarioPerfil;

class FuncionarioPermissao extends BaseModel
{
  use HasFactory;

  protected $table = 'permissao';

  protected $primaryKey = 'id_permissao';

  public $incrementing = true;

  public function perfis()
  {
      return $this->belongsToMany(
        FuncionarioPerfil::class,
          'perfil_permissao',
          'id_permissao',
          'id_perfil'
      );
  }

}
