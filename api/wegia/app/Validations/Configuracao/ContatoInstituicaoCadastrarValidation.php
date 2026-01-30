<?php

namespace app\Validations\Configuracao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ContatoInstituicaoCadastrarValidation",
 *     required={"descricao", "contato"},
 *     @OA\Property(property="descricao", type="string", description="texto para descrever o contato"),
 *     @OA\Property(property="contato", type="string", description="texto do contato")
 * )
 */
class ContatoInstituicaoCadastrarValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'descricao' => 'required|string',
            'contato'   => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.'
        ];
    }

}
