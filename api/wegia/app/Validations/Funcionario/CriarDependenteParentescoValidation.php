<?php

namespace App\Validations\Funcionario;

class CriarDependenteParentescoValidation
{
    public static function rules()
    {
        return [
            'descricao' => 'required|string|max:100|unique:funcionario_dependente_parentesco',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',
            'unique'   => 'O campo :attribute ja existe'
        ];
    }
}