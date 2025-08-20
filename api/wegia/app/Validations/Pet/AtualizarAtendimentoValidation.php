<?php

namespace App\Validations\Pet;

class AtualizarAtendimentoValidation
{
    public static function rules()
    {
        return [
            'id_atendimento'      => 'required|integer|exists:pet_atendimento,id_pet_atendimento',
            'data_atendimento'      => 'nullable|date_format:Y-m-d',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser um inteiro.',
            'exists' => 'O campo :attribute deve existir na tabela',
            'date_format' => 'O campo :attribute deve uma data no formato Y-m-d.',
        ];
    }
}