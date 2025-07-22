<?php

namespace App\Validations\Perfil;

class CadastrarPerfilValidation
{
    public static function rules()
    {
        return [
            'cargo' => 'required|string',
            'nome'  => 'required|string',
        ];
    }

    public static function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.'
        ];
    }
}