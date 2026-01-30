<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class ContribuicaoLogCriarVariasRecorrenciasDTO extends BaseDTO
{

    public string $codigo;
    public string $codigo_recorrencia;
    public string $data_geracao;
    public string $data_vencimento;
    public string $data_pagamento;
    public bool $status_pagamento;

}
