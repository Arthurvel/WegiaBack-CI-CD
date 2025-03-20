<?php

namespace App\Validations\Funcionario;

class CriarOutraInfoFuncionarioValidation
{
    public static function rules()
    {
        return [
            'id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
            'id_funcionario_lista_info' => 'required|integer|exists:funcionario_listainfo,idfuncionario_listainfo',
            'dado' => 'required|string|max:255',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute pode ter no maximo 255 caracteres.',
            'unique'   => 'O campo :attribute já está cadastrado.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente'
        ];
    }
}