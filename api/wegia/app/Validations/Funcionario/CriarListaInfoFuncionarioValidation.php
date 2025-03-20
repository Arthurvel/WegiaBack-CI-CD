<?php

namespace App\Validations\Funcionario;

class CriarListaInfoFuncionarioValidation
{
    public static function rules($pessoaId = null)
    {
        return [
            'descricao' => 'required|string|max:255|unique:funcionario_listainfo',
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