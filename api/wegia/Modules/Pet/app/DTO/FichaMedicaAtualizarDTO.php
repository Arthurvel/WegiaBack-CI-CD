<?php

namespace Modules\Pet\app\DTO;

use App\DTOs\BaseDTO;

class FichaMedicaAtualizarDTO extends BaseDTO
{

    public ?string $castrado;
    public ?string $necessidades_especiais;

}
