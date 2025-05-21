<?php

namespace App\Validations\Pet;

class BuscarAtendimentoValidation
{
    public static function rules()
    {
        return [
            'id_ficha_medica'      => 'required|integer|exists:pet_ficha_medica,id_ficha_medica',
            'buscar'      => 'nullable|string',
            'ordenacao'      => 'nullable|string|in:data_atendimento,descricao',
            'tipoOrdenacao'  => 'nullable|string|in:asc,desc,ASC,DESC',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer'
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser ium inteiro.',
            'exists' => 'O campo :attribute deve existir na tabela',
            'in' => 'O campo deve ser um dos seguintes valores: :values.',
        ];
    }
}