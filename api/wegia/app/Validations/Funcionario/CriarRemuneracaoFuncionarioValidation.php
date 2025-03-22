<?php

namespace App\Validations\Funcionario;

class CriarRemuneracaoFuncionarioValidation
{
    public static function rules()
    {
        return [
            'funcionario_id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
            'funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo' => 'required|integer|exists:funcionario_remuneracao_tipo,idfuncionario_remuneracao_tipo',
            'valor' => 'required|numeric',
            'inicio' => 'nullable|date',
            'fim' => 'nullable|date'
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute pode ter no maximo 255 caracteres.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'numeric'  => 'O campo :attribute deve ser um número.',
            'date'     => 'O campo :attribute deve ser uma data válida.'
        ];
    }
}