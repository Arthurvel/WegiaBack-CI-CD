<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeExameCadastrarValidation",
 *     required={"id_exame_tipo", "data", "arquivo"},
 *     @OA\Property(property="id_exame_tipo", type="integer", description="id do tipo de exame"),
 *     @OA\Property(property="data", format="date", type="string", description="Data do exame"),
 *     @OA\Property(property="arquivo", type="string", format="binary", description="Foto do exame(jpeg, jpg, png, máx. 5MB)"),
 * )
 */
class SaudeExameCadastrarValidation extends FormRequest
{

    protected function prepareForValidation() : void
    {
        $this->merge([
            'id_fichamedica' => $this->route('id'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_fichamedica' => 'required|integer|exists:saude_fichamedica,id_fichamedica',
            'id_exame_tipo' => 'required|integer|exists:saude_exame_tipos,id_exame_tipo',
            'data'           => 'required|string|date_format:Y-m-d',
            'arquivo'        => 'sometimes|file|mimes:jpeg,jpg,png|max:5120'
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'string'      => 'O campo :attribute deve ser texto.',
            'exists'      => 'O campo :attribute deve existir no sistema.',
            'date_format' => 'O campo :attribute deve ser no formato YYYY-mm-dd',

            'file'     => 'O arquivo enviado deve ser uma foto.',
            'mimes'    => 'A foto deve ser do tipo jpeg, jpg ou png.',
            'max'      => 'A foto deve ter no máximo 5MB.',
        ];
    }

}
