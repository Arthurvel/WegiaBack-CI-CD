<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class OrigemCadastrarDTO extends BaseDTO
{
    public string $nome_origem;
    public ?string $cpf;
    public ?string $cnpj;
    public string $telefone;
}
