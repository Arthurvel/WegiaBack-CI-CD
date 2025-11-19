<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeAtendimentoCadastrarValidation",
 *     required={"id_funcionario", "id_medico"},
 *     @OA\Property(property="id_funcionario", type="integer", description="id do funcionário"),
 *     @OA\Property(property="id_medico", type="integer", description="id do médico"),
 *     @OA\Property(property="data_atendimento", format="date", type="string", description="Data do atendimento"),
 *     @OA\Property(property="descricao", type="string", description="Descrição do atendimento"),
 *     @OA\Property(
 *         property="medicacoes",
 *         type="array",
 *         description="Lista de medicações vinculadas ao atendimento",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="medicamento", type="string", description="Nome do medicamento"),
 *             @OA\Property(property="dosagem", type="string", description="Dosagem prescrita"),
 *             @OA\Property(property="horario", type="string", description="Horário de uso"),
 *             @OA\Property(property="duracao", type="string", description="Duração do tratamento")
 *         )
 *     )
 * )
 */
class SaudeAtendimentoCadastrarValidation extends FormRequest
{

    protected function prepareForValidation() : void
    {
        $this->merge([
            'id_fichamedica' => $this->route('id'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_fichamedica'   => 'required|integer|exists:saude_fichamedica,id_fichamedica',
            'id_funcionario'   => 'required|integer|exists:funcionario,id_funcionario',
            'id_medico'        => 'required|integer|exists:saude_medicos,id_medico',
            'data_atendimento' => 'sometimes|string|date_format:Y-m-d',
            'descricao'        => 'sometimes|string',

            'medicacoes'                => 'sometimes|array',
            'medicacoes.*.medicamento'  => 'required_with:medicacoes|string|max:255',
            'medicacoes.*.dosagem'      => 'nullable|string|max:100',
            'medicacoes.*.horario'      => 'nullable|string|max:100',
            'medicacoes.*.duracao'      => 'nullable|string|max:100',
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'string'      => 'O campo :attribute deve ser texto.',
            'exists'      => 'O campo :attribute deve existir',
            'date_format' => 'Seguir o padrao Y-m-d',
            'array'             => 'O campo :attribute deve ser uma lista.',
            'required_with'     => 'O campo :attribute é obrigatório quando houver medicações.'
        ];
    }

}
