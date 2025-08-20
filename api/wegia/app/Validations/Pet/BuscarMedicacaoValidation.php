<?php

namespace App\Validations\Pet;

class BuscarMedicacaoValidation
{
    public static function rules()
    {
        return [
            'id_pet_atendimento'    => 'required|nullable|integer|exists:pet_medicacao,id_pet_atendimento',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer'
        ];
    }

    public static function messages()
    {
        return [
            'string' => 'O campo :attribute deve ser uma string.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
        ];
    }
}