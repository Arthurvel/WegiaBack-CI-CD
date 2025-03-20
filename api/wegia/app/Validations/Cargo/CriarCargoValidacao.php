<?php

namespace App\Validations\Cargo;

class CriarCargoValidacao
{
    public static function rules($pessoaId = null)
    {
        return [
            'cargo' => 'required|string|max:30',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max' => 'O campo :attribute pode ter no maximo 30 caracteres.'
        ];
    }
}