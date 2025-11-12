<?php

namespace app\Validations\Pessoa\Arquivo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PessoaTipoArquivoCadastrarValidation",
 *     required={"descricao"},
 *     @OA\Property(property="descricao", type="string", description="descricao do tipo de arquivo")
 * )
 */
class PessoaTipoArquivoCadastrarValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'descricao' => 'required|string|max:255|unique:pessoa_tipo_arquivo,descricao'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatorio.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'unique' => 'O campo :attribute deve ser unico na tabela correspondente.',
        ];
    }

}
