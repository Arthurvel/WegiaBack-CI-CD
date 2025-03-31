<?php

namespace App\Validations\Funcionario;

class CriarRemuneracaoTipoFuncionarioValidation
{
    public static function rules($pessoaId = null)
    {
        return [
            'descricao' => 'required|string|max:255|unique:funcionario_remuneracao_tipo',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute pode ter no maximo 255 caracteres.',
            'unique'   => 'O campo :attribute já está cadastrado.'
        ];
    }
}