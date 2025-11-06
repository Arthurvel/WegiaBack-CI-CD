<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class ParceiroCadastrarDTO extends BaseDTO
{

    public string $nome;
    public ?string $cpf;
    public ?string $cnpj;
    public ?string $telefone;

}
