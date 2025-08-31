<?php

namespace App\Validations;

use Illuminate\Foundation\Http\FormRequest;

class PaginacaoValidation extends FormRequest
{
    public function rules()
    {
        return [
            'buscar'         => 'nullable|string',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer',
            'ordenacao'      => 'nullable|string',
            'tipoOrdenacao'  => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O campo :attribute não existe.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }
}
