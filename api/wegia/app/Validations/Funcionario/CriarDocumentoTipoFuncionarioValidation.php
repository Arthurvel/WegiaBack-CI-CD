<?php

namespace App\Validations\Funcionario;

class CriarDocumentoTipoFuncionarioValidation
{
    public static function rules()
    {
        return [
            'nome_docfuncional'       => 'required|string|max:50',
            'descricao_docfuncional'  => 'nullable|string|max:256'
        ];
    }

    public static function messages()
    {
        return [
            'required'              => 'O campo :attribute é obrigatório.',
            'max'                   => 'O campo :attribute  deve ter no maximo 5mb'
        ];
    }
}