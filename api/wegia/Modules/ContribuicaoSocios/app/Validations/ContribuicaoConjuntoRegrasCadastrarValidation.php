<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="ContribuicaoConjuntoRegrasCadastrarValidation",
 *     required={"id_meioPagamento", "id_regra", "valor", "status"},
 *     @OA\Property(property="id_meioPagamento", type="integer", description="id do meio de pagamento"),
 *     @OA\Property(property="id_regra", type="integer", description="id da regra"),
 *     @OA\Property(property="valor", type="number", format="float", description="token do gateway"),
 *     @OA\Property(property="status", type="boolean", description="status"),
 * )
 */
class ContribuicaoConjuntoRegrasCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'id_meioPagamento' => 'required|integer|exists:contribuicao_meioPagamento,id',
            'id_regra' => [
                'required',
                'integer',
                'exists:contribuicao_regras,id',
                Rule::unique('contribuicao_conjuntoRegras')
                    ->where(fn($q) => $q->where('id_meioPagamento', $this->id_meioPagamento)),
            ],
            'valor'            => 'required|decimal:0,2',
            'status'           => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'unique'  => 'Já existe um conjunto cadastrado com esse meio de pagamento e essa regra.',
            'string'  => 'O campo :attribute deve ser uma string.',
            'exists'  => 'O campo :attribute deve existir na tabela.',
            'boolean' => 'O campo :attribute deve ser um boolean.',
            'decimal' => 'O campo :attribute deve ser um número decimal com até 2 casas.',
        ];
    }

}
