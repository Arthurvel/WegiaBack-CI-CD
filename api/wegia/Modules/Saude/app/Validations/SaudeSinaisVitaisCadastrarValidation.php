<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeSinaisVitaisCadastrarValidation",
 *     required={"id_funcionario", "data"},
 *     @OA\Property(property="id_funcionario", type="integer", description="ID do funcionário associado"),
 *     @OA\Property(property="data", type="string", format="date-time", description="Data e hora da coleta dos sinais vitais"),
 *     @OA\Property(property="saturacao", type="number", format="float", description="Saturação de oxigênio no sangue"),
 *     @OA\Property(property="pressao_arterial", type="string", maxLength=10, description="Pressão arterial medida"),
 *     @OA\Property(property="frequencia_cardiaca", type="integer", description="Frequência cardíaca medida"),
 *     @OA\Property(property="frequencia_respiratoria", type="integer", description="Frequência respiratória medida"),
 *     @OA\Property(property="temperatura", type="number", format="float", description="Temperatura corporal"),
 *     @OA\Property(property="hgt", type="number", format="float", description="Nível de glicemia capilar (HGT)")
 * )
 */
class SaudeSinaisVitaisCadastrarValidation extends FormRequest
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
            'id_fichamedica'         => 'required|integer|exists:saude_fichamedica,id_fichamedica',
            'id_funcionario'         => 'required|integer|exists:funcionario,id_funcionario',
            'data'                   => 'required|date',
            'saturacao'              => 'nullable|numeric|between:0,100',
            'pressao_arterial'       => 'nullable|string|max:10',
            'frequencia_cardiaca'    => 'nullable|integer|min:0',
            'frequencia_respiratoria'=> 'nullable|integer|min:0',
            'temperatura'            => 'nullable|numeric',
            'hgt'                    => 'nullable|numeric'
        ];
    }

    public function messages() : array
    {
        return [
            'required'      => 'O campo :attribute é obrigatório.',
            'integer'       => 'O campo :attribute deve ser um número inteiro.',
            'numeric'       => 'O campo :attribute deve ser numérico.',
            'date'          => 'O campo :attribute deve ser uma data válida.',
            'exists'        => 'O :attribute informado não existe no sistema.',
            'max'           => 'O campo :attribute deve ter no máximo :max caracteres.',
            'between'       => 'O campo :attribute deve estar entre :min e :max.',
            'min'           => 'O campo :attribute deve ser maior ou igual a :min.'
        ];
    }

}
