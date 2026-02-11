<?php

namespace app\Validations\Atendido;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendidoAtualizarValidation",
 *     required={"atendido_status_idatendido_status"},
 *     @OA\Property(property="atendido_status_idatendido_status", type="integer", description="id do status do atendido"),
 * )
 */
class AtendidoAtualizarValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            'atendido_status_idatendido_status' => 'required|int|exists:atendido_status,idatendido_status',
        ];
    }

    public function messages(): array
    {
        return [
            'exists' => 'O campo :attribute não existe na tabela correspondente.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }
}
