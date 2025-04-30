<?php

namespace App\Validations\Pet;

class CriarFichaMedicaValidation
{
    public static function rules()
    {
        return [
            'id_pet'      => 'required|integer|unique:pet_ficha_medica|exists:pet,id_pet',
            'castrado'      => 'required|string|max:1|in:s,n',
            'necessidades_especiais'      => 'nullable|string|max:255'
        ];
    }

    public static function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.',
            'castrado.max'  => 'O campo :attribute deve ter no máximo 1 caracter.',
            'necessidades_especiais.max'  => 'O campo :attribute deve ter no máximo 255 caracter.',
            'unique'   => 'O campo :attribute já existe.',
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser ium inteiro.',
            'exists' => 'O campo :attribute deve existir na tabela',
            'in' => 'O campo :attribute deve ser s ou n.',
        ];
    }
}