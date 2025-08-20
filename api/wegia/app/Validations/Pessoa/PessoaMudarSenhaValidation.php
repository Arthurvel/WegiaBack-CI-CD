<?php

namespace App\Validations\Pessoa;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PessoaMudarSenhaValidation",
 *     required={"senha", "confirmar_senha"},
 *     @OA\Property(property="senha", type="string", description="Senha"),
 *     @OA\Property(property="confirmar_senha", type="string", description="Confirmar Senha")
 * )
 */
class PessoaMudarSenhaValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'senha' => 'required|string|min:6',
            'confirmar_senha' => 'required|string|min:6|same:senha',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'A :attribute é obrigatória.',
            'min' => 'A :attribute deve ter no mínimo 6 caracteres.',
            'same' => 'A confirmação da senha deve ser igual à senha.',
        ];
    }

}
