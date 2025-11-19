<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeAlergiaCadastrarValidation",
 *     required={"nome"},
 *     @OA\Property(property="nome", type="string", description="Nome da alergia"),
 * )
 */
class SaudeAlergiaCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'nome' => 'required|string|unique:saude_alergia,nome',
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'string'      => 'O campo :attribute deve ser texto.',
            'unique'      => 'O campo :attribute deve ser unico na tabela.',
        ];
    }

}
