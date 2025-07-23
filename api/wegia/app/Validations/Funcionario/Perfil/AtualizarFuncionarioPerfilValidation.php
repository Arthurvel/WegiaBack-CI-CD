<?php

namespace App\Validations\Funcionario\Perfil;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtualizarFuncionarioPerfilValidation",
 *     @OA\Property(property="cargo", type="string", description="Nome do cargo"),
 *     @OA\Property(property="nome", type="string", description="Nome do perfil")
 * )
 */
class AtualizarFuncionarioPerfilValidation extends FormRequest
{
    public function rules()
    {
        return [
            'cargo' => 'sometimes|string',
            'nome'  => 'sometimes|string',
        ];
    }

    public function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.'
        ];
    }
}