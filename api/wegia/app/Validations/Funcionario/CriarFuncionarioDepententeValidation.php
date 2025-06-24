<?php

namespace App\Validations\Funcionario;

use App\Rules\validarSeNaoEOFuncionario;
use Illuminate\Validation\Rule;

class CriarFuncionarioDepententeValidation
{
    public static function rules($id_funcionario = null)
    {
        return [
            "id_funcionario" => "required|integer|exists:funcionario,id_funcionario",
            "id_pessoa" => [
                "required",
                "integer",
                new validarSeNaoEOFuncionario($id_funcionario),
            ],
            'id_parentesco' => 'required|integer|exists:funcionario_dependente_parentesco,id_parentesco',
        ];
    }

    public static function messages()
    {
        return [
            'required'              => 'O campo :attribute é obrigatório.',
            'exists'                => 'O campo :attribute não existe.',
            'integer'               => 'O campo :attribute deve ser um número inteiro.',
        ];
    }
}