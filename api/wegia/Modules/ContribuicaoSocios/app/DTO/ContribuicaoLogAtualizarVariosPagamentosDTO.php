<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class ContribuicaoLogAtualizarVariosPagamentosDTO extends BaseDTO
{

    public string $codigo;
    public string $data_pagamento;
    private bool $status_pagamento = true;

}
