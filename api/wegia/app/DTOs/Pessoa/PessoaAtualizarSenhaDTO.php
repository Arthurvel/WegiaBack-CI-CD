<?php

namespace App\DTOs\Pessoa;

use App\DTOs\BaseDTO;

class PessoaAtualizarSenhaDTO extends BaseDTO
{
    public string $senha;
    public string $id_pessoa;
}
