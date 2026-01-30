<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeMedicacaoAministracaoCadastrarEmMassaValidation",
 *     required={"id_funcionario", "aplicacao"},
 *     @OA\Property(property="id_funcionario", type="integer", description="id do funcionário"),
 *     @OA\Property(property="aplicacao", type="string", format="date", description=""),
 *     @OA\Property(
 *         property="medicacao",
 *         type="array",
 *         description="Lista com id da medicação",
 *         @OA\Items(type="integer", description="id do medicamento")
 *     )
 * )
 */
class SaudeMedicacaoAministracaoCadastrarEmMassaValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'aplicacao'      => 'required|string|date_format:Y-m-d',
            'id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
            'medicacao'      => 'required|array',
            'medicacao.*'    => 'required|integer|exists:saude_medicacao,id_medicacao'
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'string'      => 'O campo :attribute deve ser texto.',
            'exists'      => 'O campo :attribute deve existir',
            'date_format' => 'Seguir o padrao Y-m-d',
        ];
    }


}
