<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class TipoMovimentacaoBuscarTodosSemPaginacaoParamsValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'tipo' => 'sometimes|string|in:e,s'
        ];
    }

    public function messages() : array
    {
        return [
            'string'      => 'O campo :attribute deve ser texto.',
            'in' => 'O campo :attribute deve respeitar as seguintes opções: :values',
        ];
    }

}
