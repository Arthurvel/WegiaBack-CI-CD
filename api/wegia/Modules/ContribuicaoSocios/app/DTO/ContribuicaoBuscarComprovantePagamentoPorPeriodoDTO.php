<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class ContribuicaoBuscarComprovantePagamentoPorPeriodoDTO extends BaseDTO
{

    public string $cpf_cnpj;
    public string $data_inicio;
    public string $data_fim;

}
