<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeIntercorrenciaCadastrarValidation",
 *     required={"descricao", "id_funcionario"},
 *     @OA\Property(property="descricao", type="string", description="Descricao da intercorrencia"),
 *     @OA\Property(property="id_funcionario", type="integer", description="")
 * )
 */
class SaudeIntercorrenciaCadastrarValidation extends FormRequest
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
            'id_fichamedica' => 'required|integer|exists:saude_fichamedica,id_fichamedica',
            'id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
            'descricao'      => 'required|string'
        ];
    }

    public function messages() : array
    {
        return [
            'required'      => 'O campo :attribute é obrigatório.',
            'integer'       => 'O campo :attribute deve ser um número inteiro.',
            'exists'        => 'O :attribute informado não existe no sistema.',
        ];
    }

}
