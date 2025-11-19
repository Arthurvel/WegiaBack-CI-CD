<?php

namespace Modules\Pet\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendimentoCadastrarValidation",
 *     required={"data_atendimento", "descricao", "medicamentos"},
 *     @OA\Property(
 *         property="data_atendimento",
 *         type="string",
 *         format="date",
 *         description="Data do atendimento (formato Y-m-d)"
 *     ),
 *     @OA\Property(
 *          property="descricao",
 *          type="string",
 *          description="Descricao do atendimento"
 *      ),
 *     @OA\Property(
 *         property="medicamentos",
 *         type="array",
 *         description="Array de IDs de medicamentos",
 *         @OA\Items(type="integer", description="ID do medicamento")
 *     )
 * )
 */
class AtendimentoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'data_atendimento' => 'required|date_format:Y-m-d',
            'descricao'        => 'required|string',
            'medicamentos'     => 'required|array',
            'medicamentos.*'   => 'integer|exists:pet_medicamento,id_medicamento',
        ];
    }

    public function messages() : array
    {
        return [
            'date_format' => 'O campo :attribute deve uma data no formato Y-m-d.',
            'required'     => 'Campo :attribute obrigatorio',
            'medicamentos.array'        => 'Os medicamentos devem ser enviados em formato de array.',
            'medicamentos.*.integer'    => 'Cada medicamento deve ser um número inteiro.',
            'medicamentos.*.exists'     => 'Algum dos medicamentos informados não existe no sistema.',
        ];
    }

}
