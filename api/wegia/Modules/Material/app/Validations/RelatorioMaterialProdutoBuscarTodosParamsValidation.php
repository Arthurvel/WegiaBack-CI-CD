<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class RelatorioMaterialProdutoBuscarTodosParamsValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'periodo_inicial' => 'sometimes|date|date_format:Y-m-d',
            'periodo_final'   => 'sometimes|date|date_format:Y-m-d|after_or_equal:periodo_inicial',
            'id_produto'      => 'sometimes|integer|min:1|exists:material_produto,id_produto',
            'id_almoxarifado' => 'sometimes|integer|min:1|exists:material_almoxarifado,id_almoxarifado'
        ];
    }

    public function messages(): array
    {
        return [
            'periodo_inicial.date'         => 'O campo período inicial deve ser uma data válida (YYYY-MM-DD).',
            'periodo_final.date'           => 'O campo período final deve ser uma data válida (YYYY-MM-DD).',
            'periodo_final.after_or_equal' => 'O período final deve ser igual ou posterior ao período inicial.',
            'integer'                      => 'O :attribute deve ser um número inteiro.',
            'min'                          => 'O :attribute deve ser maior que zero.',
            'exists'                       => 'O :attribute deve existir'
        ];
    }
}
