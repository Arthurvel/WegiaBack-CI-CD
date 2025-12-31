<?php

namespace app\Validations\Configuracao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ContatoInstituicaoAtualizarValidation",
 *     @OA\Property(property="descricao", type="string", description="texto para descrever o contato"),
 *     @OA\Property(property="contato", type="string", description="texto do contato")
 * )
 */
class ContatoInstituicaoAtualizarValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'descricao' => 'sometimes|string',
            'contato'   => 'sometimes|string'
        ];
    }

    public function messages(): array
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.'
        ];
    }

}
