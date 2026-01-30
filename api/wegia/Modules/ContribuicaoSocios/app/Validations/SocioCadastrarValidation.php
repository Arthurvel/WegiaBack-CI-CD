<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SocioCadastrarValidation",
 *     required={"id_pessoa","id_sociostatus","id_sociotipo"},
 *     @OA\Property(property="id_pessoa", type="integer", description="ID da pessoa vinculada"),
 *     @OA\Property(property="id_sociostatus", type="integer", description="Status do sócio"),
 *     @OA\Property(property="id_sociotipo", type="integer", description="Tipo do sócio"),
 *     @OA\Property(property="id_sociotag", type="integer", nullable=true, description="Tag do sócio"),
 *     @OA\Property(property="email", type="string", nullable=true, description="Email do sócio"),
 *     @OA\Property(property="valor_periodo", type="number", format="decimal", nullable=true, description="Valor pago no período"),
 *     @OA\Property(property="data_referencia", type="string", format="date", nullable=true, description="Data de referência")
 * )
 */
class SocioCadastrarValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_pessoa'      => 'required|integer|exists:pessoa,id_pessoa|unique:socio,id_pessoa',
            'id_sociostatus' => 'required|integer|exists:socio_status,id_sociostatus',
            'id_sociotipo'   => 'required|integer|exists:socio_tipo,id_sociotipo',
            'id_sociotag'    => 'nullable|integer|exists:socio_tag,id_sociotag',
            'email'          => 'nullable|email|max:256',
            'valor_periodo'  => 'nullable|numeric|min:0',
            'data_referencia'=> 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O valor informado em :attribute não existe no sistema.',
            'unique'   => 'Já existe um sócio vinculado a esta pessoa.',
            'email'    => 'O campo :attribute deve ser um email válido.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'date'     => 'O campo :attribute deve ser uma data válida.',
            'min'      => 'O campo :attribute não pode ser menor que zero.',
        ];
    }
}
