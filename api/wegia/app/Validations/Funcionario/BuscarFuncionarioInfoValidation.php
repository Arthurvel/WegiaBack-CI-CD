<?php

namespace App\Validations\Funcionario;

class BuscarFuncionarioInfoValidation
{
    public static function rules()
    {
        return [
            'id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
            'buscar'         => 'nullable|string',
            'ordenacao'      => 'nullable|string',
            'tipoOrdenacao'  => 'nullable|string',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer'
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'exists' => 'O campo :attribute não existe em sua tabela.',
            'string' => 'O campo :attribute deve ser uma string.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
        ];
    }
}