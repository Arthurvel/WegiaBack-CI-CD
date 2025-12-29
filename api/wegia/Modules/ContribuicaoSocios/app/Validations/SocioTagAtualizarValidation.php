<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="SocioTagAtualizarValidation",
 *     required={"tag"},
 *     @OA\Property(property="tag", type="string", description="Tag do socio")
 * )
 */
class SocioTagAtualizarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'tag' => [
                'required',
                'string',
                'max:255',
                Rule::unique('socio_tag', 'tag')->ignore($this->route('id_sociotag')),
            ]
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
