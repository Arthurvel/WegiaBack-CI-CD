<?php

namespace App\DTOs\Funcionario\Perfil;

use App\DTOs\BaseDTO;

class AtualizarPerfilDTO extends BaseDTO
{
    public ?string $nome = null;
    public ?string $cargo = null;
}