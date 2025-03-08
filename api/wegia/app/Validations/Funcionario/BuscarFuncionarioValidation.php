<?php

namespace App\Validations\Funcionario;

class BuscarFuncionarioValidation
{
    public static function rules()
    {
        return [
            'id_situacao'    => 'nullable|integer',
            'buscar'         => 'nullable|string',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer'
        ];
    }

    public static function messages()
    {
        return [
            'string' => 'O campo :attribute deve ser uma string.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
        ];
    }
}