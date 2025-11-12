<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Material\app\Repositories\TipoMovimentacaoRepository;
use Modules\Material\app\Repositories\TransacaoProdutoRepository;
use Modules\Material\app\Repositories\TransacaoRepository;
use Modules\Material\app\Rules\EstoqueDisponivelRule;


/**
 * @OA\Schema(
 *     schema="TransacaoProdutoAtualizarValidation",
 *     @OA\Property( property="quantidade", type="integer", description="Quantidade de produtos movimentados"),
 *     @OA\Property( property="valor_unitario", type="number", format="float", description="Valor unitário do produto")
 * )
 */
class TransacaoProdutoAtualizarValidation extends FormRequest
{

    public function rules(): array
    {

        $tipoMovimentacao = null;
        $id_almoxarifado  = null;
        $id_produto       = null;

        if ($this->filled('id')) {
            $transacaoProdutoRepository = app(TransacaoProdutoRepository::class);
            $transacaoRepository        = app(TransacaoRepository::class);
            $tipoMovimentacaoRepository = app(TipoMovimentacaoRepository::class);

            $transacaoProduto = $transacaoProdutoRepository->buscarPorId($this->input('id'));;
            $transacao        = $transacaoRepository->buscarPorId($transacaoProduto->transacao);
            $tipo = $tipoMovimentacaoRepository->buscarPorId($transacao->id_tipo_movimentacao);

            $tipoMovimentacao = $tipo->tipo ?? null;
            $id_almoxarifado  = $transacaoProduto->id_almoxarifado;
            $id_produto       = $transacaoProduto->id_produto;
        }

        return [
            'quantidade'     => [
                'sometimes',
                'integer',
                'min:1',
                new EstoqueDisponivelRule(
                    app(TransacaoProdutoRepository::class),
                    $id_almoxarifado ?? 0,
                    $tipoMovimentacao ?? 'e',
                    $id_produto
                ),
            ],
            'valor_unitario'    => 'sometimes|numeric|min:0',
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
