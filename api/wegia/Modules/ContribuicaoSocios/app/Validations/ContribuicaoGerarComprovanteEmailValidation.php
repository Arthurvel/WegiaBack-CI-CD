<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ContribuicaoGerarComprovanteEmailValidation",
 *     required={"cpf_cnpj", "data_inicio", "data_fim"},
 *     @OA\Property(property="cpf_cnpj", type="string", description="CPF ou CNPJ do sócio"),
 *     @OA\Property(property="data_inicio", type="string", format="date", description="Data inicial do período"),
 *     @OA\Property(property="data_fim", type="string", format="date", description="Data final do período")
 * )
 */
class ContribuicaoGerarComprovanteEmailValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            'cpf_cnpj'   => 'required|string',
            'data_inicio'=> 'required|date_format:Y-m-d',
            'data_fim'   => 'required|date_format:Y-m-d|after_or_equal:data_inicio',
        ];
    }

    public function messages(): array
    {
        return [
            'required'                => 'O :attribute é obrigatório.',
            'string'                  => 'O :attribute deve ser uma string.',
            'date_format'             => 'A :attribute deve ser uma data válida.',
            'data_fim.after_or_equal' => 'A data final deve ser maior ou igual à data inicial.',
        ];
    }
}
