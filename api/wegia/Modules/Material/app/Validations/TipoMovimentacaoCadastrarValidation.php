<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="TipoMovimentacaoCadastrarValidation",
 *     required={"nome", "tipo"},
 *     @OA\Property(property="nome", type="string", description="Nome da movimentacao"),
 *     @OA\Property(property="tipo", type="string", description="Tipo de transacao (entrada e saida)", enum={"e", "s"})
 * )
 */
class TipoMovimentacaoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'nome'     => 'required|string|max:100|unique:material_tipo_movimentacao,nome',
            'tipo'     => 'required|string|max:1|in:e,s',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.',
            'max'      => 'O campo :attribute deve ter no máximo :max caracteres.',
            'unique'   => 'O campo :attribute deve ser único na tabela.',
            'in'       => 'O campo :attribute deve ser e ou s.'
        ];
    }


}
