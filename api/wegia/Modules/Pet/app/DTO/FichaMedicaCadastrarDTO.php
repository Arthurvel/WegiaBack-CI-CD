<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class FichaMedicaCadastrarDTO extends BaseDTO
{
    public string $id_pet;
    public string $castrado;
    public ?string $necessidades_especiais;

}
