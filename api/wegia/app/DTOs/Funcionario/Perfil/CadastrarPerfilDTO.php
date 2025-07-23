<?php

namespace App\DTOs\Funcionario\Perfil;

use App\DTOs\BaseDTO;

class CadastrarPerfilDTO extends BaseDTO
{
    public string $nome;
    public string $cargo;
}