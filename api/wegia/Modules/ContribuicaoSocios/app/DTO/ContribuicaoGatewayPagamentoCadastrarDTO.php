<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class ContribuicaoGatewayPagamentoCadastrarDTO extends BaseDTO
{

    public string $plataforma;
    public string $endPoint;
    public string $token;
    public bool $status;

}
