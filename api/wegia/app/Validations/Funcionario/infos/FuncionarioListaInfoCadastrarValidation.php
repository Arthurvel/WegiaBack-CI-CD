<?php

namespace app\Validations\Funcionario\infos;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FuncionarioListaInfoCadastrarValidation",
 *     required={"descricao"},
 *     @OA\Property(property="descricao", type="string", maxLength=255, description="Descricao único")
 * )
 */
class FuncionarioListaInfoCadastrarValidation extends FormRequest
{

    public function rules($pessoaId = null) : array
    {
        return [
            'descricao' => 'required|string|max:255|unique:funcionario_listainfo',
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
