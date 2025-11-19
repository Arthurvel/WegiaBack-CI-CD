<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use App\Validations\PaginacaoValidation;

class ContribuicaoConjuntoRegrasBuscarTodosPaginadoParamsValidation extends PaginacaoValidation
{

    protected array $ordenacoesPermitidas = [
        "regra",
        "meio",
        "valor"
    ];

}
