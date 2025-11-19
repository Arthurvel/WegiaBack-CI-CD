<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class RelatorioMaterialEstoqueBuscarTodosParamsValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'id_almoxarifado'      => 'sometimes|integer|min:1|exists:material_almoxarifado,id_almoxarifado',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => 'O id do almoxarifado deve ser um número inteiro.',
            'min' => 'O id do almoxarifado deve ser maior que zero.',
        ];
    }
}
