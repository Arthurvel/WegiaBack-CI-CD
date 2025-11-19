<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="ContribuicaoConjuntoRegrasAtualizarValidation",
 *     @OA\Property(property="id_meioPagamento", type="integer", description="id do meio de pagamento"),
 *     @OA\Property(property="id_regra", type="integer", description="id da regra"),
 *     @OA\Property(property="valor", type="number", format="float", description="token do gateway"),
 *     @OA\Property(property="status", type="boolean", description="status"),
 * )
 */
class ContribuicaoConjuntoRegrasAtualizarValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'id_meioPagamento' => 'sometimes|integer|exists:contribuicao_meioPagamento,id',
            'id_regra' => [
                'sometimes',
                'integer',
                'exists:contribuicao_regras,id',
                Rule::unique('contribuicao_conjuntoRegras')
                    ->where(fn($q) => $q->where('id_meioPagamento', $this->id_meioPagamento))
                    ->ignore($this->route('id')),
            ],
            'valor'  => 'sometimes|decimal:0,2',
            'status' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'string'  => 'O campo :attribute deve ser uma string.',
            'exists'  => 'O campo :attribute deve existir na tabela.',
            'boolean' => 'O campo :attribute deve ser um boolean.'
        ];
    }

}
