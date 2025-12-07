<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SocioAtualizarValidation",
 *     type="object", *
 *     @OA\Property(property="nome", type="string", example="João da Silva"),
 *     @OA\Property(property="cpf", type="string", example="12345678900"),
 *     @OA\Property(property="telefone", type="string", example="21999999999"),
 *     @OA\Property(property="data_nascimento", type="string", format="date", example="1995-08-20"),
 *
 *     @OA\Property(property="id_sociostatus", type="integer", example=1),
 *     @OA\Property(property="id_sociotipo", type="integer", example=2),
 *     @OA\Property(property="id_sociotag", type="integer", nullable=true, example=3),
 *     @OA\Property(property="email", type="string", example="joao@email.com"),
 *     @OA\Property(property="valor_periodo", type="number", example=150.00),
 *     @OA\Property(property="data_referencia", type="string", format="date", example="2025-01-01")
 * )
 */
class SocioAtualizarValidation extends FormRequest
{
    public function rules(): array
    {

        $idPessoa = $this->route('id_pessoa');

        return [
            'nome'            => 'sometimes|string|max:100',
            'cpf'             => "sometimes|string|unique:pessoa,cpf,{$idPessoa},id_pessoa",
            'telefone'        => 'sometimes|string|max:25',
            'data_nascimento' => 'sometimes|date',

            'id_sociostatus' => 'sometimes|integer|exists:socio_status,id_sociostatus',
            'id_sociotipo'   => 'sometimes|integer|exists:socio_tipo,id_sociotipo',
            'id_sociotag'    => 'sometimes|integer|exists:socio_tag,id_sociotag',
            'email'          => 'sometimes|email|max:256',
            'valor_periodo'  => 'sometimes|numeric|min:0',
            'data_referencia'=> 'sometimes|date',
        ];
    }

    public function messages(): array
    {
        return [
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O valor informado em :attribute não existe no sistema.',
            'unique'   => 'Esse valor já está em uso.',
            'email'    => 'O campo :attribute deve ser um email válido.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'date'     => 'O campo :attribute deve ser uma data válida.',
            'min'      => 'O campo :attribute não pode ser menor que zero.',
        ];
    }
}
