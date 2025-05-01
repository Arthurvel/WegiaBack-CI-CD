<?php

namespace App\Validations\Pessoa\Dependente;


class DependenteExisteValidation
{
    public static function rules()
    {
        return [
            'id_dependente' => 'required|integer|exists:pessoa_dependente,id_dependente',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo é obrigatório.',
            'integer' => 'O campo deve ser um número inteiro.',
            'exists' => 'O campo deve existir na tabela.',
        ];
    }
}