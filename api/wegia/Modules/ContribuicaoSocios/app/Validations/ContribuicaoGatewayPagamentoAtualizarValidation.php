<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ContribuicaoGatewayPagamentoAtualizarValidation",
 *     @OA\Property(property="plataforma", type="string", description="Nome da plataforma"),
 *     @OA\Property(property="endPoint", type="string", description="endpoint do gateway"),
 *     @OA\Property(property="token", type="string", description="token do gateway"),
 *     @OA\Property(property="status", type="boolean", description="status"),
 * )
 */
class ContribuicaoGatewayPagamentoAtualizarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'plataforma' => 'sometimes|string|max:50',
            'endPoint'   => 'sometimes|string|max:255',
            'token'      => 'sometimes|string|max:100',
            'status'     => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'string' => 'O campo :attribute deve ser uma string.',
            'max'    => 'O campo :attribute deve ter no máximo :max caracteres.',
            'boolean' => 'O campo :attribute deve ser um boolean.'
        ];
    }

}
