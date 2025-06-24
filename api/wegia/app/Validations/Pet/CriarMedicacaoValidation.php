<?php

namespace App\Validations\Pet;

class CriarMedicacaoValidation
{
    public static function rules()
    {
        return [
            'id_medicamento'      => 'required|integer|exists:pet_medicamento,id_medicamento',
            'id_pet_atendimento'      => 'required|integer|exists:pet_atendimento,id_pet_atendimento',
            'data_medicacao'      => 'nullable|date_format:Y-m-d',
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