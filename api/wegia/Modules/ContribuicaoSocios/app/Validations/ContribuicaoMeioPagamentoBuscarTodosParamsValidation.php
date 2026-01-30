<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use App\Validations\PaginacaoValidation;

class ContribuicaoMeioPagamentoBuscarTodosParamsValidation extends PaginacaoValidation
{
    protected array $ordenacoesPermitidas = [
        'meio'
    ];
}
