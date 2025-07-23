<?php

namespace App\Validations\Pet;

class AtualizarFichaMedicaValidation
{
    public static function rules()
    {
        return [
            'castrado'      => 'nullable|string|max:1|in:s,n',
            'necessidades_especiais'      => 'nullable|string|max:255',
            'id_ficha_medica' => 'required|integer|exists:pet_ficha_medica,id_ficha_medica'
        ];
    }

    public static function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.',
            'castrado.max'  => 'O campo :attribute deve ter no máximo 1 caracter.',
            'necessidades_especiais.max'  => 'O campo :attribute deve ter no máximo 255 caracter.',
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser ium inteiro.',
            'exists' => 'O campo :attribute deve existir na tabela',
            'in' => 'O campo :attribute deve ser s ou n.',
        ];
    }
}