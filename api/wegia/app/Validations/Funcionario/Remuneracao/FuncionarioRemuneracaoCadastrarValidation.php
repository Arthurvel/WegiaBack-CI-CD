<?php

namespace app\Validations\Funcionario\Remuneracao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FuncionarioRemuneracaoCadastrarValidation",
 *     required={"funcionario_id_funcionario", "funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo", "valor"},
 *     @OA\Property(property="funcionario_id_funcionario", type="integer", description="id do funcionario"),
 *     @OA\Property(property="funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo", type="integer", description="id do tipo de remuneracao"),
 *     @OA\Property(property="valor", type="float", description="valor da remuneracao"),
 *     @OA\Property(property="inicio", type="string", format="date", description="inicio da remuneracao"),
 *     @OA\Property(property="fim", type="string", format="date", description="fim da remuneracao")
 * )
 */
class FuncionarioRemuneracaoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'funcionario_id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
            'funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo' => 'required|integer|exists:funcionario_remuneracao_tipo,idfuncionario_remuneracao_tipo',
            'valor' => 'required|numeric',
            'inicio' => 'nullable|date',
            'fim' => 'nullable|date'
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute pode ter no maximo 255 caracteres.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'numeric'  => 'O campo :attribute deve ser um número.',
            'date'     => 'O campo :attribute deve ser uma data válida.'
        ];
    }

}
