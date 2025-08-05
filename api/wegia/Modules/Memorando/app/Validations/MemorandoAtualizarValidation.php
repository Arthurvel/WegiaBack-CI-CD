<?php

namespace Modules\Memorando\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="MemorandoAtualizarValidation",
 *     required={"status_memorando"},
 *     @OA\Property(property="status_memorando", type="string", description="id do destinatario")
 * )
 */
class MemorandoAtualizarValidation extends FormRequest
{
    public function rules()
    {
        return [
            'status_memorando' => 'required|string|in:Ativo,Lido,Não Lido,Importante,Pendente,Arquivado',
        ];
    }

    public function messages()
    {
        return [
            'in' => 'Esse status nao existe',
        ];
    }
}
