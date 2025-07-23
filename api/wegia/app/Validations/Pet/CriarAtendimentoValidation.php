<?php

namespace App\Validations\Pet;

class CriarAtendimentoValidation
{
    public static function rules()
    {
        return [
            'id_ficha_medica'      => 'required|integer|exists:pet_ficha_medica,id_ficha_medica',
            'data_atendimento'      => 'required|date_format:Y-m-d',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser ium inteiro.',
            'exists' => 'O campo :attribute deve existir na tabela',
            'date_format' => 'O campo :attribute deve uma data no formato Y-m-d.',
        ];
    }
}