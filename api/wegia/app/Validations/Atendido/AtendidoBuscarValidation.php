<?php

namespace App\Validations\Atendido;

use Illuminate\Foundation\Http\FormRequest;

class AtendidoBuscarValidation extends FormRequest
{
    public function rules() : array
    {

        $withPermitidos =   [
            'pessoa',
            'atendidoTipo',
            'atendidoStatus',
        ];

        return [
            'id_status'    => 'nullable|integer',
            'buscar'         => 'nullable|string',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer',
            'ordenacao'      => 'nullable|string|in:cpf,nome',
            'tipoOrdenacao'  => 'nullable|string|in:ASC,DESC',
            'with' => [
                'nullable',
                'string',
                'regex:/^[a-zA-Z0-9_,]+$/',
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
            'string' => 'O campo :attribute deve ser uma string.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'enum' => 'O campo :attribute deve ser um dos seguintes valores: :values.',
            'with.regex' => 'O campo :attribute deve conter apenas letras, números e vírgulas.',
        ];
    }
}
