<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use App\Validations\PaginacaoValidation;

class ContribuicaoBuscarTodosParamsValidation extends PaginacaoValidation
{

    protected array $ordenacoesPermitidas = [
        'nome',
        'plataforma',
        'meio_pagamento',
        'data_geracao',
        'data_vencimento',
        'data_pagamento',
        'valor',
        'status_pagamento'
    ];

    public function rules(): array
    {
        $parentRules = parent::rules();

        $parentRules['ordenacao'] = ['nullable', 'string', 'in:' . implode(',', $this->ordenacoesPermitidas)];

        return array_merge($parentRules, [
            'periodo'   => 'sometimes|integer|min:1',
            'id_socio'  => 'sometimes|integer|exists:socio,id_socio',
            'status'    => 'sometimes|integer|in:0,1',
        ]);
    }

    public function messages(): array
    {
        return array_merge(parent::messages(), [
            'in'      => 'O campo :attribute não possui essa opção.'
        ]);
    }

}
