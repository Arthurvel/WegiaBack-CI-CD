<?php

namespace App\Validations\Atendido\Ocorrencia;

use Illuminate\Foundation\Http\FormRequest;

class AtendidoOcorrenciaBuscarValidation extends FormRequest
{
    public function rules() : array
    {
        $withPermitidos =   [
            'tipos',
            'documento',
            'atendido',
            'atendido.pessoa',
            'funcionario',
            'funcionario.pessoa'
        ];

        return [
            'id_tipo'        => 'nullable|int|exists:atendido_ocorrencia_tipos,idatendido_ocorrencia_tipos',
            'buscar'         => 'nullable|string',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer',
            'ordenacao'      => 'nullable|string',
            'tipoOrdenacao'  => 'nullable|string',
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
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
        ];
    }
}
