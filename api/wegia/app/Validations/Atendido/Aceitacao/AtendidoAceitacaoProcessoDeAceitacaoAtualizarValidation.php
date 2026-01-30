<?php

namespace app\Validations\Atendido\Aceitacao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendidoAceitacaoProcessoDeAceitacaoAtualizarValidation",
 *     required={"status"},
 *     @OA\Property(property="id_status", type="integer", description="id do status")
 * )
 */
class AtendidoAceitacaoProcessoDeAceitacaoAtualizarValidation extends FormRequest
{
    public function rules() : array
    {
        return [
            'id_status' => 'required|int|exists:pa_status,id',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'int'      => 'O campo :attribute deve ser numerico.',
            'unique'   => 'O campo :attribute existir na tabela',
        ];
    }
}
