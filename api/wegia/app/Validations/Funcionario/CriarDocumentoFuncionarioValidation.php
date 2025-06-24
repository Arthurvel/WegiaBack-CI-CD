<?php

namespace App\Validations\Funcionario;

class CriarDocumentoFuncionarioValidation
{
    public static function rules()
    {
        return [
            'arquivo'         => 'required|file|mimes:pdf,jpg,png|max:5120',
            'id_funcionario'  => 'required|integer|exists:funcionario,id_funcionario',
            'id_docfuncional' => 'required|integer',
        ];
    }

    public static function messages()
    {
        return [
            'required'              => 'O campo :attribute é obrigatório.',
            'file'                  => 'O campo :attribute deve ser uma arquivo.',
            'id_funcionario.exists' => 'O funcionário informado não existe.',
            'integer'               => 'O campo :attribute deve ser um número inteiro.',
            'mimes'                 => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg e .png',
            'max'                   => 'O campo :attribute  deve ter no maximo 5mb'
        ];
    }
}