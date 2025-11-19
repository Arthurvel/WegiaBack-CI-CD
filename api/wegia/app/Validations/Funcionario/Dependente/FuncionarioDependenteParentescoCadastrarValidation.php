<?php

namespace app\Validations\Funcionario\Dependente;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="FuncionarioDependenteParentescoCadastrarValidation",
 *     required={"descricao"},
 *     @OA\Property(property="descricao", type="string", description="Tipo de parentesco"),
 * )
 */
class FuncionarioDependenteParentescoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'descricao' => 'required|string|max:100|unique:funcionario_dependente_parentesco',
        ];
    }

    public function messages() :array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',
            'unique'   => 'O campo :attribute ja existe'
        ];
    }

}
