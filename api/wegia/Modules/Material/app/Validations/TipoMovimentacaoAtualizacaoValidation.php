<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="TipoMovimentacaoAtualizacaoValidation",
 *     @OA\Property(property="nome", type="string", description="Nome da movimentacao"),
 *     @OA\Property(property="tipo", type="string", description="Tipo de transacao (entrada e saida)", enum={"e", "s"})
 * )
 */
class TipoMovimentacaoAtualizacaoValidation extends FormRequest
{

    public function rules() : array
    {
        $id = $this->route('id');

        return [
            'nome' => [
                'sometimes',
                'string',
                'max:100',
                Rule::unique('material_tipo_movimentacao', 'nome')->ignore($id, 'id_tipo_movimentacao')
            ],
            'tipo'     => 'sometimes|string|max:1|in:e,s',
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
