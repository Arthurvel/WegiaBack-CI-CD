<?php

namespace App\Validations\Funcionario\Perfil;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CadastrarFuncionarioPerfilValidation",
 *     required={"cargo", "nome"},
 *     @OA\Property(property="cargo", type="string", description="Nome do cargo"),
 *     @OA\Property(property="nome", type="string", description="Nome do perfil")
 * )
 */
class CadastrarFuncionarioPerfilValidation extends FormRequest
{
    public function rules()
    {
        return [
            'cargo' => 'required|string',
            'nome'  => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.'
        ];
    }
}