<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use App\Validations\PaginacaoValidation;

class SocioTagBuscarTodosPaginadoParamsValidation extends PaginacaoValidation
{
    protected array $ordenacoesPermitidas = [
        'tag'
    ];
}
