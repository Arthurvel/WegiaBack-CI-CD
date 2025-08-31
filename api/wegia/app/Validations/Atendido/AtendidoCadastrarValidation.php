<?php

namespace App\Validations\Atendido;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendidoCadastrarValidation",
 *     required={"pessoa_id_pessoa", "atendido_tipo_idatendido_tipo", "atendido_status_idatendido_status"},
 *     @OA\Property(property="pessoa_id_pessoa", type="integer", description="id da pessoa"),
 *     @OA\Property(property="atendido_tipo_idatendido_tipo", type="integer", description="id do tipo do atendido"),
 *     @OA\Property(property="atendido_status_idatendido_status", type="integer", description="id do status do atendido"),
 * )
 */
class AtendidoCadastrarValidation extends FormRequest
{
    public function rules() : array
    {
        return [
            'pessoa_id_pessoa' => 'required|int|exists:pessoa,id_pessoa',
            'atendido_tipo_idatendido_tipo' => 'required|int|exists:atendido_tipo,idatendido_tipo',
            'atendido_status_idatendido_status' => 'required|int|exists:atendido_status,idatendido_status',
        ];
    }

    public function messages() : array
    {
        return [
            'exists'   => 'O campo :attribute não existe na tabela correspondente.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }
}
