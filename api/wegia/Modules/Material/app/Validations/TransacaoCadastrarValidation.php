<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Material\app\Repositories\TipoMovimentacaoRepository;
use Modules\Material\app\Repositories\TransacaoProdutoRepository;
use Modules\Material\app\Rules\EstoqueDisponivelRule;

/**
 * @OA\Schema(
 *     schema="TransacaoCadastrarValidation",
 *     required={"id_tipo_movimentacao", "id_almoxarifado", "id_parceiro", "produtos"},
 *     @OA\Property(
 *         property="id_tipo_movimentacao",
 *         type="integer",
 *         description="ID do tipo de movimentação vinculada à transação"
 *     ),
 *     @OA\Property(
 *         property="id_almoxarifado",
 *         type="integer",
 *         description="ID do almoxarifado responsável pela transação"
 *     ),
 *     @OA\Property(
 *         property="id_parceiro",
 *         type="integer",
 *         description="ID do parceiro envolvido na transação"
 *     ),
 *     @OA\Property(
 *         property="produtos",
 *         type="array",
 *         description="Lista de produtos incluídos nesta transação",
 *         @OA\Items(
 *             required={"id_produto", "quantidade", "valor_unitario"},
 *             @OA\Property(
 *                 property="id_produto",
 *                 type="integer",
 *                 description="ID do produto movimentado"
 *             ),
 *             @OA\Property(
 *                 property="quantidade",
 *                 type="integer",
 *                 description="Quantidade de produtos movimentados"
 *             ),
 *             @OA\Property(
 *                 property="valor_unitario",
 *                 type="number",
 *                 format="float",
 *                 description="Valor unitário do produto"
 *             )
 *         )
 *     )
 * )
 */
class TransacaoCadastrarValidation extends FormRequest
{

    public function rules(): array
    {

        $tipoMovimentacao = null;
        if ($this->filled('id_tipo_movimentacao')) {
            $tipoMovimentacaoRepository = app(TipoMovimentacaoRepository::class);

            $tipoMovimentacaoModel = $tipoMovimentacaoRepository->buscarPorId($this->input('id_tipo_movimentacao'));;

            $tipoMovimentacao = $tipoMovimentacaoModel->tipo ?? null;
        }

        return [
            'id_tipo_movimentacao'         => 'required|integer|exists:material_tipo_movimentacao,id_tipo_movimentacao',
            'id_almoxarifado'              => 'required|integer|exists:material_almoxarifado,id_almoxarifado',
            'id_parceiro'                  => 'required|integer|exists:material_parceiro,id_parceiro',

            'produtos'                     => [
                'required',
                'array',
                'min:1',
                new EstoqueDisponivelRule(
                    app(TransacaoProdutoRepository::class),
                    $this->input('id_almoxarifado', 0),
                    $tipoMovimentacao ?? 'e'
                )
            ],
            'produtos.*.id_produto'        => 'required|integer|exists:material_produto,id_produto',
            'produtos.*.quantidade'        => 'required|integer|min:1',
            'produtos.*.valor_unitario'    => 'required|numeric|min:0',
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
            'array'     => 'O campo :attribute deve ser um array.',
            'date'      => 'O campo :attribute deve ser uma data válida.',
        ];
    }
}

