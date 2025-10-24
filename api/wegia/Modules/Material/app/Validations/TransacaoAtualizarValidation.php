<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TransacaoAtualizarValidation",
 *     @OA\Property(property="id_produto", type="integer", description="ID do produto vinculado à transação"),
 *     @OA\Property(property="id_tipo_movimentacao", type="integer", description="ID do tipo de movimentação"),
 *     @OA\Property(property="id_almoxarifado", type="integer", description="ID do almoxarifado responsável"),
 *     @OA\Property(property="id_parceiro", type="integer", description="ID do parceiro envolvido"),
 *     @OA\Property(property="valor_unitario", type="number", format="float", description="Valor unitário do produto"),
 *     @OA\Property(property="quantidade", type="integer", description="Quantidade de produtos movimentados")
 * )
 */
class TransacaoAtualizarValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_produto'            => 'sometimes|integer|exists:material_produto,id_produto',
            'id_tipo_movimentacao'  => 'sometimes|integer|exists:material_tipo_movimentacao,id_tipo_movimentacao',
            'id_almoxarifado'       => 'sometimes|integer|exists:material_almoxarifado,id_almoxarifado',
            'id_parceiro'           => 'sometimes|integer|exists:material_parceiro,id_parceiro',
            'valor_unitario'        => 'sometimes|numeric|min:0',
            'quantidade'            => 'sometimes|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'required'  => 'O campo :attribute é obrigatório.',
            'integer'   => 'O campo :attribute deve ser um número inteiro.',
            'numeric'   => 'O campo :attribute deve ser numérico.',
            'exists'    => 'O campo :attribute não faz referência a um registro válido.',
            'min'       => 'O campo :attribute deve ter um valor mínimo de :min.',
        ];
    }
}
