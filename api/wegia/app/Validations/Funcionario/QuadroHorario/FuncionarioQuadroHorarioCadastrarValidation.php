<?php

namespace app\Validations\Funcionario\QuadroHorario;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FuncionarioQuadroHorarioCadastrarValidation",
 *     required={"id_escala", "id_tipo"},
 *     @OA\Property(property="id_escala", type="integer", description="ID da escala", example=2),
 *     @OA\Property(property="id_tipo", type="integer", description="ID do tipo de quadro horário", example=3),
 *     @OA\Property(property="carga_horaria", type="string", maxLength=200, nullable=true, description="Carga horária do funcionário", example="08:00"),
 *     @OA\Property(property="entrada1", type="string", maxLength=200, nullable=true, description="Primeira entrada do funcionário", example="09:00"),
 *     @OA\Property(property="saida1", type="string", maxLength=200, nullable=true, description="Primeira saída do funcionário", example="12:00"),
 *     @OA\Property(property="entrada2", type="string", maxLength=200, nullable=true, description="Segunda entrada do funcionário", example="13:00"),
 *     @OA\Property(property="saida2", type="string", maxLength=200, nullable=true, description="Segunda saída do funcionário", example="17:00"),
 *     @OA\Property(property="total", type="string", maxLength=200, nullable=true, description="Total de horas trabalhadas", example="08:00"),
 *     @OA\Property(property="dias_trabalhados", type="string", maxLength=200, nullable=true, description="Dias trabalhados pelo funcionário", example="5"),
 *     @OA\Property(property="folga", type="string", maxLength=200, nullable=true, description="Dias de folga do funcionário", example="2")
 * )
 */
class FuncionarioQuadroHorarioCadastrarValidation extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'id_funcionario' => $this->route('id_funcionario'),
        ]);
    }


    public function rules() : array
    {
        return [
            'id_funcionario'   => 'required|integer|exists:funcionario,id_funcionario',
            'id_escala'        => 'required|integer|exists:escala_quadro_horario,id_escala',
            'id_tipo'          => 'required|integer|exists:tipo_quadro_horario,id_tipo',
            'carga_horaria'    => 'nullable|string|max:200',
            'entrada1'         => 'nullable|string|max:200',
            'saida1'           => 'nullable|string|max:200',
            'entrada2'         => 'nullable|string|max:200',
            'saida2'           => 'nullable|string|max:200',
            'total'            => 'nullable|string|max:200',
            'dias_trabalhados' => 'nullable|string|max:200',
            'folga'            => 'nullable|string|max:200',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute pode ter no maximo 255 caracteres.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
            'integer'  => 'O campo :attribute deve ser um número inteiro',
            'string'     => 'O campo :attribute deve ser uma string',
        ];
    }

}
