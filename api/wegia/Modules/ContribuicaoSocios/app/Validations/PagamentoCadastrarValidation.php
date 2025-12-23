<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoMeioDePagamento;
use Modules\ContribuicaoSocios\app\Rules\DataVencimentoRule;
use Modules\ContribuicaoSocios\app\Rules\PagamentoCartaoRule;
use Modules\ContribuicaoSocios\app\Rules\ParcelasValidaRule;
use Modules\ContribuicaoSocios\app\Rules\ValorRegraValidaRule;

/**
 * @OA\Schema(
 *     schema="PagamentoCadastrarValidation",
 *     required={"id_socio", "id_contribuicao_conjuntoRegras", "valor"},
 *     @OA\Property(property="id_socio", type="integer", description="id do socio"),
 *     @OA\Property(property="id_contribuicao_meioPagamento", type="integer", description="id do meio de pagamento"),
 *     @OA\Property(property="valor", type="integer", description="valor do pagamento"),
 *     @OA\Property(property="parcelas", type="integer", description="quantidade de parcelas"),
 *     @OA\Property(property="data_vencimento", type="integer", description="valor do pagamento"),
 *      @OA\Property(property="cartao_hash", type="string", description="hash do cartao")
 * )
 */
class PagamentoCadastrarValidation extends FormRequest
{

    protected $meio;

    protected function prepareForValidation()
    {
        $this->meio = ContribuicaoMeioDePagamento::where('id', $this->input('id_contribuicao_meioPagamento'))
            ->where('status', 1)
            ->firstOrFail();

    }

    public function rules() : array
    {

        return [
            'id_socio'                       => 'required|integer|exists:socio,id_socio',
            'id_contribuicao_meioPagamento'  => 'required|integer|exists:contribuicao_meioPagamento,id',

            'valor' => [
                'required',
                'numeric',
                new ValorRegraValidaRule($this->meio),
            ],

            'data_vencimento' => [
              'sometimes',
              'numeric',
              new DataVencimentoRule($this->meio)
            ],

            'parcelas' => [
                'sometimes',
                'integer',
                new ParcelasValidaRule($this->meio),
            ],

            'cartao_hash' => [
                'nullable',
                'string',
                new PagamentoCartaoRule($this->meio),
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'string'  => 'O campo :attribute deve ser uma string.',
            'min'     => 'O campo :attribute deve ter no minimo :min.',
            'boolean' => 'O campo :attribute deve ser um boolean.',
            'exists'  => 'O campo :attribute deve existir no sistema.',
        ];
    }

}
