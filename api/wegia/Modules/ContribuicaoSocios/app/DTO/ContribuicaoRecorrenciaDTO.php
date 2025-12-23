<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class ContribuicaoRecorrenciaDTO extends BaseDTO
{

    public int $id_socio;
    public int $id_gateway;
    public string $codigo;
    public string $valor;
    public string $data_inicio;
    public ?string $data_fim = null;
    public bool $status = true;

}
