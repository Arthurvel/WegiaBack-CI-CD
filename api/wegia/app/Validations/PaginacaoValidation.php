<?php

namespace App\Validations;

class PaginacaoValidation
{
    public static function rules()
    {
        return [
            'buscar'         => 'nullable|string',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer',
            'ordenacao'      => 'nullable|string',
            'tipoOrdenacao'  => 'nullable|string',
        ];
    }

    public static function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O campo :attribute não existe.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }
}