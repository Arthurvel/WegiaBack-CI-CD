<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ContribuicaoMeioPagamentoCadastrarValidation",
 *     required={"meio", "id_plataforma", "status"},
 *     @OA\Property(property="meio", type="string", description="Nome do meio de pagamento"),
 *     @OA\Property(property="id_plataforma", type="integer", description="id da plataforma"),
 *     @OA\Property(property="status", type="boolean", description="status"),
 * )
 */
class ContribuicaoMeioPagamentoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'meio'          => 'required|string|max:45|unique:contribuicao_meioPagamento,meio',
            'id_plataforma' => 'required|integer|exists:contribuicao_gatewayPagamento,id',
            'status'     => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'string'  => 'O campo :attribute deve ser uma string.',
            'max'     => 'O campo :attribute deve ter no máximo :max caracteres.',
            'boolean' => 'O campo :attribute deve ser um boolean.',
            'exists'  => 'O campo :attribute deve existir no sistema.',
            'unique'  => 'O campo :attribute deve ser único'
        ];
    }

}
