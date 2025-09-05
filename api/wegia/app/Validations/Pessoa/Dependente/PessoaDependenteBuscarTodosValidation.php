<?php

namespace app\Validations\Pessoa\Dependente;

use Illuminate\Foundation\Http\FormRequest;

class PessoaDependenteBuscarTodosValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'with'           => 'nullable|string',
            'buscar'         => 'nullable|string',
            'ordenacao'      => 'nullable|string|in:nome,parentesco',
            'tipoOrdenacao'  => 'nullable|string|in:asc,desc,ASC,DESC',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer'
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo é obrigatório.',
            'integer' => 'O campo deve ser um número inteiro.',
            'exists' => 'O campo deve existir na tabela.',
            'in' => 'O campo deve ser um dos seguintes valores: :values.',
        ];
    }

}
