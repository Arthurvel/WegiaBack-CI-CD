<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class SocioCadastrarDTO extends BaseDTO
{

    public int $id_pessoa;
    public int $id_sociostatus;
    public int $id_sociotipo;
    public ?int $id_sociotag;
    public ?string $email;
    public ?float $valor_periodo;
    public ?string $data_referencia;

}
