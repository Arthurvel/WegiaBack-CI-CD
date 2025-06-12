<?php

namespace App\Validations\Pessoa;

use Illuminate\Validation\Rule;

class CriarOuAtualizarImagemPessoaValidation
{
    public static function rules($pessoaId = null)
    {
        return [
            'imagem' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo é obrigatório.',
            'mimes'    => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg, jpeg e .png',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',
        ];
    }
}