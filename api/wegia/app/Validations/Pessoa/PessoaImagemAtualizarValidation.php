<?php

namespace app\Validations\Pessoa;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PessoaImagemAtualizarValidation",
 *     required={"imagem"},
 *     @OA\Property(property="imagem", type="string", format="binary", description="Arquivo da foto da pessoa (jpeg, jpg, png, máx. 5MB)"),
 * )
 */
class PessoaImagemAtualizarValidation extends FormRequest
{

    public function rules($pessoaId = null) : array
    {
        return [
            'imagem' => 'required|file|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo é obrigatório.',
            'mimes'    => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg, jpeg e .png',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',
        ];
    }

}
