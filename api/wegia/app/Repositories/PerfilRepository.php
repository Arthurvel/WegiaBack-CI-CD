<?php

namespace App\Repositories;

use App\DTOs\Perfil\CadastrarPerfilDTO;
use App\Models\Perfil\Perfil;

class PerfilRepository
{

  public function cadastrarPerfil(CadastrarPerfilDTO $dto)
  {
    return Perfil::create($dto->toArray());
  }

}