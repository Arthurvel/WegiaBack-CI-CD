<?php

namespace App\Validations\Atendido;

use Illuminate\Foundation\Http\FormRequest;

class AtendidoBuscarPorIdValidation extends FormRequest
{
    public function rules() : array
    {

        $withPermitidos =   [
            'pessoa',
            'pessoa.funcionario',
            'atendidoTipo',
            'atendidoStatus',
        ];

        return [
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

    public function messages() : array
    {
        return [
            'string'     => 'O campo :attribute deve ser uma string.',
            'with.regex' => 'O campo :attribute deve conter apenas letras, números e vírgulas.',
        ];
    }
}
