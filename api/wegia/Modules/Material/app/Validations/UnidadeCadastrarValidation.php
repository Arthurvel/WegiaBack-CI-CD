<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UnidadeCadastrarValidation",
 *     required={"descricao"},
 *     @OA\Property(property="descricao", type="string", description="Nome da unidade")
 * )
 */
class UnidadeCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'descricao'     => 'required|string|max:100|unique:material_unidade,descricao'
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
