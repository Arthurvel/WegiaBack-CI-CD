<?php

namespace App\Validations\Funcionario;

class BuscarRemuneracaoPorFuncionarioValidation
{
    public static function rules()
    {
        return [
            'id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
            'buscar'         => 'nullable|string',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer'
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