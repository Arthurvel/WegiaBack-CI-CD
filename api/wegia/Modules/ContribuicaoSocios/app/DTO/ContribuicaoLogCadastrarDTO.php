<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class ContribuicaoLogCadastrarDTO extends BaseDTO
{
    public int $id_socio;
    public int $id_gateway;
    public int $id_meio_pagamento;
    public string $codigo;
    public string $valor;
        public string $data_geracao;
    public string $data_vencimento;
    public bool $status_pagamento = false;
    public ?string $url = null;
}
