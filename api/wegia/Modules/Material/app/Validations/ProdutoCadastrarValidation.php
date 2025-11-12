<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ProdutoCadastrarValidation",
 *     required={"id_categoria", "id_unidade", "descricao"},
 *     @OA\Property(property="id_categoria", type="integer", description="ID da categoria do produto"),
 *     @OA\Property(property="id_unidade", type="integer", description="ID da unidade do produto"),
 *     @OA\Property(property="descricao", type="string", description="Descrição do produto"),
 *     @OA\Property(property="codigo", type="string", description="Código único do produto"),
 *     @OA\Property(property="oculto", type="boolean", description="Define se o produto está oculto (0 = visível, 1 = oculto)")
 * )
 */
class ProdutoCadastrarValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'id_categoria' => 'required|integer|exists:material_categoria,id_categoria',
            'id_unidade'   => 'required|integer|exists:material_unidade,id_unidade',
            'descricao'    => 'required|string|max:150|unique:material_produto,descricao',
            'codigo'       => 'nullable|string|max:15|unique:material_produto,codigo',
            'oculto'       => 'sometimes|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O campo :attribute deve referenciar um registro válido.',
            'string'   => 'O campo :attribute deve ser uma string.',
            'max'      => 'O campo :attribute deve ter no máximo :max caracteres.',
            'unique'   => 'O campo :attribute deve ser único na tabela.',
            'boolean'  => 'O campo :attribute deve ser verdadeiro (1) ou falso (0).'
        ];
    }
}
