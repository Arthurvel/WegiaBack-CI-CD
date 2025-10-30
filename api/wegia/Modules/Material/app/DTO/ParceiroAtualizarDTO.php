<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class ParceiroAtualizarDTO extends BaseDTO
{

    public ?string $nome;
    public ?string $cpf;
    public ?string $cnpj;
    public ?string $telefone;

}

