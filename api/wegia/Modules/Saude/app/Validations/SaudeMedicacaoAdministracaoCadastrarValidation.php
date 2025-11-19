<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeMedicacaoAdministracaoCadastrarValidation",
 *     required={"aplicacao", "funcionario_id_funcionario"},
 *     @OA\Property(property="aplicacao", type="string", format="date", description=""),
 *     @OA\Property(property="funcionario_id_funcionario", type="integer", description="Nome do medico")
 * )
 */
class SaudeMedicacaoAdministracaoCadastrarValidation extends FormRequest
{

    protected function prepareForValidation() : void
    {
        $this->merge([
            'saude_medicacao_id_medicacao' => $this->route('id'),
        ]);
    }

    public function rules() : array
    {
        return [
            'saude_medicacao_id_medicacao'   => 'required|integer|exists:saude_medicacao,id_medicacao',
            'aplicacao' => 'required|string|date_format:Y-m-d H:i:s',
            'funcionario_id_funcionario'   => 'required|integer|exists:funcionario,id_funcionario',
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
