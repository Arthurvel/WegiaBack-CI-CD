<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeExameTipoCadastrarValidation",
 *     required={"descricao"},
 *     @OA\Property(property="descricao", type="string", description="descricao do tipo"),
 * )
 */
class SaudeExameTipoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'descricao'  => 'required|string|max:255|unique:saude_exame_tipos,descricao',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
            'max'      => 'O campo :attribute deve conter no maximo :max caracteres.'
        ];
    }

}

