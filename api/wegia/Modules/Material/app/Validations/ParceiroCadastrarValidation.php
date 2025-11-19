<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * @OA\Schema(
 *     schema="ParceiroCadastrarValidation",
 *     required={"nome"},
 *     @OA\Property(property="nome", type="string", description="Nome do parceiro"),
 *     @OA\Property(property="cpf", type="string", description="CPF do parceiro (obrigatório se CNPJ não informado)"),
 *     @OA\Property(property="cnpj", type="string", description="CNPJ do parceiro (obrigatório se CPF não informado)"),
 *     @OA\Property(property="telefone", type="string", description="Telefone do parceiro")
 * )
 */
class ParceiroCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'nome'     => 'required|string|max:100',
            'cpf'      => 'sometimes|string|max:100',
            'cnpj'     => 'sometimes|string|max:100',
            'telefone' => 'sometimes|string|max:100'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.',
            'max'      => 'O campo :attribute deve ter no máximo :max caracteres.',
            'unique'   => 'O campo :attribute deve ser único na tabela.',
            'cpf_ou_cnpj' => 'Informe pelo menos um CPF ou CNPJ.'
        ];
    }

    protected function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $cpf = $this->input('cpf');
            $cnpj = $this->input('cnpj');

            if (empty($cpf) && empty($cnpj)) {
                $validator->errors()->add('cpf_ou_cnpj', 'Informe pelo menos um CPF ou CNPJ.');
            }
        });
    }

}
