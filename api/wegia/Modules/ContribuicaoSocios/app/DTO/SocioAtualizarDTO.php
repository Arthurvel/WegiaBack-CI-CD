<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class SocioAtualizarDTO extends BaseDTO
{

    public int $id_sociostatus;
    public int $id_sociotipo;
    public ?int $id_sociotag;
    public ?string $email;
    public ?float $valor_periodo;
    public ?string $data_referencia;

}
