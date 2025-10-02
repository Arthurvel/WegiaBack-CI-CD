<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeEnfermidadeAtualizarDTO extends BaseDTO
{

    public ?string $data_diagnostico = null;
    public ?int $status = null;

}
