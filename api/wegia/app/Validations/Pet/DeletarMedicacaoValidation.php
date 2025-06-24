<?php

namespace App\Validations\Pet;

class DeletarMedicacaoValidation
{
    public static function rules()
    {
        return [
            'id_medicacao'      => 'required|integer|exists:pet_medicacao,id_medicacao',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser um inteiro.',
            'exists' => 'O campo :attribute deve existir na tabela',
        ];
    }
}