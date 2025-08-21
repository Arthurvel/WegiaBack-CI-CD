<?php

namespace Modules\Pet\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="EspecieCadastrarValidation",
 *     required={"descricao"},
 *     @OA\Property(property="descricao", type="string", description="Campo descrição")
 * )
 */
class EspecieCadastrarValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'descricao' => 'required|string|max:200|unique:pet_especie,descricao',
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute deve ter no máximo 200 caracteres.',
            'unique' => 'O campo :attribute já existe.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }

}
