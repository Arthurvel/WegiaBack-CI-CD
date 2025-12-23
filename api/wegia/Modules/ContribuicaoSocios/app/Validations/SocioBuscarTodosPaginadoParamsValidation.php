<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use App\Validations\PaginacaoValidation;

class SocioBuscarTodosPaginadoParamsValidation extends PaginacaoValidation
{
    protected array $ordenacoesPermitidas = [
        'nome',
        'email',
        'telefone',
        'endereco',
        'cpf',
        'tipo',
        'data_nascimento'
    ];
}

