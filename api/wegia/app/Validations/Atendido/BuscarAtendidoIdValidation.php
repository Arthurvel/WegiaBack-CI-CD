<?php

namespace App\Validations\Atendido;

class BuscarAtendidoIdValidation
{
    public static function rules()
    {

        $withPermitidos =   [
            'pessoa',
            'pessoa.funcionario',
            'atendidoTipo',
            'atendidoStatus',
        ];

        return [
            'id'   => 'required|integer|exists:atendido,idatendido',
            'with' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Z0-9_,.]+$/',
                function ($attribute, $value, $fail) use ($withPermitidos) {
                    $relacionamento = explode(',', $value);
                    $invalido = array_diff($relacionamento, $withPermitidos);

                    if (!empty($invalido)) {
                        $fail("Os relacionamentos informados são inválidos: " . implode(', ', $invalido));
                    }
                },
            ],
        ];
    }

    public static function messages()
    {
        return [
            'required'   => 'O campo :attribute é obrigatório.',
            'exists'     => 'O campo :attribute deve existir na tabela atendido.',
            'string'     => 'O campo :attribute deve ser uma string.',
            'integer'    => 'O campo :attribute deve ser um número inteiro.',
            'with.regex' => 'O campo :attribute deve conter apenas letras, números e vírgulas.',
        ];
    }
}