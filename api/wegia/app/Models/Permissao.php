<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Perfil\Perfil;

class Permissao extends BaseModel
{
  use HasFactory;

  protected $table = 'permissao';

  protected $primaryKey = 'id_permissao';

  public $incrementing = true;

  public function perfis()
  {
      return $this->belongsToMany(
          Perfil::class,
          'perfil_permissao',
          'id_permissao',
          'id_perfil'
      );
  }

}
