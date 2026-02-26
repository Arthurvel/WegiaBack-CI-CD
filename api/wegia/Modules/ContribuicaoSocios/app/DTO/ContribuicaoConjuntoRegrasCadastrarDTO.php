<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class ContribuicaoConjuntoRegrasCadastrarDTO extends BaseDTO
{

    public int $id_meioPagamento;
    public int $id_regra;
    public string $valor;
    public bool $status;

}
