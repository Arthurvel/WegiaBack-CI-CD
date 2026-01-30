<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SocioTagCadastrarValidation",
 *     required={"tag"},
 *     @OA\Property(property="tag", type="string", description="Tag do socio")
 * )
 */
class SocioTagCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'tag' => 'required|string|max:255|unique:socio_tag,tag',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute deve ser obrigatorio',
            'string'   => 'O campo :attribute deve ser uma string.',
            'unique'   => 'O campo :attribute deve ser único'
        ];
    }

}
