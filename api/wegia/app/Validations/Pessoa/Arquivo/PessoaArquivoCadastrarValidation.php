<?php

namespace app\Validations\Pessoa\Arquivo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PessoaArquivoCadastrarValidation",
 *     required={"arquivo", "id_pessoa_tipo_arquivo"},
 *     @OA\Property(property="arquivo", type="string", format="binary", description="Arquivo da foto do pet (jpeg, jpg, png, máx. 5MB)"),
 *     @OA\Property(property="id_pessoa_tipo_arquivo", type="integer", description="Id do tipo de arquivo")
 * )
 */
class PessoaArquivoCadastrarValidation extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'id_pessoa' => $this->route('id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id_pessoa'              => 'required|int|exists:pessoa,id_pessoa',
            'id_pessoa_tipo_arquivo' => 'required|int|exists:pessoa_tipo_arquivo,id_pessoa_tipo_arquivo',
            'arquivo'                => 'required|file|mimes:jpeg,jpg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatorio.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'exists' => 'O campo :attribute deve existir na tabela correspondente.',

            'file'     => 'O arquivo enviado deve ser uma foto.',
            'mimes'    => 'A foto deve ser do tipo jpeg, jpg ou png.',
            'arquivo.max'      => 'A foto deve ter no máximo 5MB.',
        ];
    }

}
