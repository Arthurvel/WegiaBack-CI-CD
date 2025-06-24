<?php

namespace App\Validations\Pet;

class CriarEspecieValidation
{
    public static function rules()
    {
        return [
            'descricao'      => 'required|string|max:200|unique:pet_especie,descricao',
        ];
    }

    public static function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.',
            'max'  => 'O campo :attribute deve ter no máximo 200 caracteres.',
            'unique'   => 'O campo :attribute já existe.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }
}