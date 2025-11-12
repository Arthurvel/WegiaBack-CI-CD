<?php

namespace app\Validations\Funcionario\Dependente;

use App\Rules\validarSeNaoEOFuncionario;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="FuncionarioDependenteCadastrarValidation",
 *     required={"id_funcionario", "id_pessoa", "id_parentesco"},
 *     @OA\Property(property="id_funcionario", type="integer", description="ID do funcionário"),
 *     @OA\Property(property="id_pessoa", type="integer", description="id da pessoa que é dependente"),
 *     @OA\Property(property="id_parentesco", type="integer", description="ID do parentesco do dependente")
 * )
 */
class FuncionarioDependenteCadastrarValidation extends FormRequest
{

    public static function rules() : array
    {
        return [
            "id_funcionario" => "required|integer|exists:funcionario,id_funcionario",
            "id_pessoa" => 'required|integer|exists:pessoa,id_pessoa',
            'id_parentesco' => 'required|integer|exists:funcionario_dependente_parentesco,id_parentesco',
        ];
    }

    public function messages() : array
    {
        return [
            'required'              => 'O campo :attribute é obrigatório.',
            'exists'                => 'O campo :attribute não existe.',
            'integer'               => 'O campo :attribute deve ser um número inteiro.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('id_pessoa', [
            new validarSeNaoEOFuncionario($this->input('id_funcionario')),
        ], function () {
            return $this->filled('id_funcionario');
        });
    }

}
