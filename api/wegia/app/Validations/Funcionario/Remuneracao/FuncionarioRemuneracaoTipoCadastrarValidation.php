<?php

namespace app\Validations\Funcionario\Remuneracao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FuncionarioRemuneracaoTipoCadastrarValidation",
 *     required={"descricao"},
 *     @OA\Property(property="descricao", type="string", maxLength=255, description="Descricao do tipo")
 * )
 */
class FuncionarioRemuneracaoTipoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'descricao' => 'required|string|max:255|unique:funcionario_remuneracao_tipo',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute pode ter no maximo 255 caracteres.',
            'unique'   => 'O campo :attribute já está cadastrado.'
        ];
    }

}
