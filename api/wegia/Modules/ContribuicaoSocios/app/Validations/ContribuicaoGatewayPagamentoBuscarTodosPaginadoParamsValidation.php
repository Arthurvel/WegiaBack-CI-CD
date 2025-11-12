<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use App\Validations\PaginacaoValidation;

class ContribuicaoGatewayPagamentoBuscarTodosPaginadoParamsValidation extends PaginacaoValidation
{
    protected array $ordenacoesPermitidas = [
        'plataforma'
    ];
}
