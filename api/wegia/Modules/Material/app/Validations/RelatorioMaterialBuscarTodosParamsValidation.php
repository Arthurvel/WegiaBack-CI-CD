<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class RelatorioMaterialBuscarTodosParamsValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'periodo_inicial'      => 'sometimes|date|date_format:Y-m-d',
            'periodo_final'        => 'sometimes|date|date_format:Y-m-d|after_or_equal:periodo_inicial',
            'id_tipo_movimentacao' => 'sometimes|integer|min:1',
            'tipo_movimentacao'    => 'sometimes|string|in:e,s',
            'id_parceiro'          => 'sometimes|integer|min:1',
            'id_responsavel'       => 'sometimes|integer|min:1',
            'id_almoxarifado'      => 'sometimes|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'periodo_inicial.date' => 'O campo período inicial deve ser uma data válida (YYYY-MM-DD).',
            'periodo_final.date' => 'O campo período final deve ser uma data válida (YYYY-MM-DD).',
            'periodo_final.after_or_equal' => 'O período final deve ser igual ou posterior ao período inicial.',

            'id_tipo_movimentacao.integer' => 'O campo tipo de movimentação deve ser um número inteiro.',
            'id_tipo_movimentacao.min' => 'O id do tipo de movimentação deve ser maior que zero.',

            'tipo_movimentacao.in' => 'O tipo de movimentação deve ser "e" (entrada) ou "s" (saída).',

            'id_parceiro.integer' => 'O id do parceiro deve ser um número inteiro.',
            'id_parceiro.min' => 'O id do parceiro deve ser maior que zero.',

            'id_responsavel.integer' => 'O id do responsável deve ser um número inteiro.',
            'id_responsavel.min' => 'O id do responsável deve ser maior que zero.',

            'id_almoxarifado.integer' => 'O id do almoxarifado deve ser um número inteiro.',
            'id_almoxarifado.min' => 'O id do almoxarifado deve ser maior que zero.',
        ];
    }

}
