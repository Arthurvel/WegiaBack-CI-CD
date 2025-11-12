<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AlmoxarifadoAtualizarValidation",
 *     required={"descricao"},
 *     @OA\Property(property="descricao", type="string", description="Nome do almoxarifado")
 * )
 */
class AlmoxarifadoAtualizarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'descricao' => 'required|string|max:240|unique:material_almoxarifado,descricao',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.',
            'max'      => 'O campo :attribute deve ter no máximo :max caracteres.',
            'unique'   => 'O campo :attribute deve ser único na tabela.'
        ];
    }

}
