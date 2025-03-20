<?php

namespace App\Validations\Situacao;

class CriarSituacaoValidacao
{
    public static function rules($pessoaId = null)
    {
        return [
            'situacao' => 'required|string|max:30',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max' => 'O campo :attribute pode ter no maximo 30 caracteres.'
        ];
    }
}