<?php

namespace App\Validations\Funcionario;

class IdFuncionarioValidation
{
    public static function rules()
    {
        return [
            'id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'exists' => 'O campo :attribute não existe na tabela correspondente.',
        ];
    }
}