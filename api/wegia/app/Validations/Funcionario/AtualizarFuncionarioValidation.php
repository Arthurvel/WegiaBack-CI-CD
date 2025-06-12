<?php

namespace App\Validations\Funcionario;

class AtualizarFuncionarioValidation
{
    public static function rules()
    {
        return [
            'id_cargo'                         => 'nullable|integer|exists:cargo,id_cargo',
            'id_situacao'                      => 'nullable|integer|exists:situacao,id_situacao',
            'data_admissao'                    => 'nullable|date_format:Y-m-d',
            'pis'                              => 'nullable|string|max:140',
            'ctps'                             => 'nullable|string|max:150',
            'uf_ctps'                          => 'nullable|string|max:20',
            'numero_titulo'                    => 'nullable|string|max:150',
            'zona'                             => 'nullable|string|max:30',
            'secao'                            => 'nullable|string|max:40',
            'certificado_reservista_numero'    => 'nullable|string|max:100',
            'certificado_reservista_serie'     => 'nullable|string|max:100',
        ];
    }

    public static function messages()
    {
        return [
            'integer'     => 'O campo :attribute deve ser um número inteiro.',
            'exists'      => 'O valor informado para :attribute não é válido.',
            'date_format' => 'O campo :attribute deve estar no formato AAAA-MM-DD.',
            'string'      => 'O campo :attribute deve ser uma string.',
            'max'         => 'O campo :attribute não pode ter mais de :max caracteres.',
        ];
    }
}
