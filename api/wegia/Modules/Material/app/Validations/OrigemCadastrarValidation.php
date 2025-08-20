<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="OrigemCadastrarValidation",
 *     required={"nome_origem", "telefone"},
 *     @OA\Property(property="nome_origem", type="string", description="Nome da origem"),
 *     @OA\Property(property="cnpj", type="string", description="CNPJ (14 dígitos)"),
 *     @OA\Property(property="cpf", type="string", description="CPF (11 dígitos)"),
 *     @OA\Property(property="telefone", type="string", description="Telefone com DDD")
 * )
 */
class OrigemCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'nome_origem' => 'required|string|max:100',
            'cnpj'        => 'nullable|string|max:14|required_without:cpf',
            'cpf'         => 'nullable|string|max:11|required_without:cnpj',
            'telefone'    => 'required|string|max:11',
        ];
    }

    public function messages(): array
    {
        return [
            'string'           => 'O campo :attribute deve ser uma string.',
            'max'              => 'O campo :attribute deve ter no máximo :max caracteres.',
            'required_without' => 'O campo :attribute é obrigatório quando o outro não está presente.'
        ];
    }

}
