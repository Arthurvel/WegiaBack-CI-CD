<?php

namespace App\Validations\Pessoa;

class AtualizarPessoaValidation
{
    public static function rules()
    {
        return [
            'nome' => 'nullable|string|max:100',
            'sobrenome' => 'nullable|string|max:100',
            'sexo' => 'nullable|string|size:1',
            'telefone' => 'nullable|string|max:25',
            'data_nascimento' => 'nullable|date',
            'imagem' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'cep' => 'nullable|string|max:10',
            'estado' => 'nullable|string|max:5',
            'cidade' => 'nullable|string|max:40',
            'bairro' => 'nullable|string|max:40',
            'logradouro' => 'nullable|string|max:100',
            'numero_endereco' => 'nullable|string|max:80',
            'complemento' => 'nullable|string|max:50',
            'ibge' => 'nullable|string|max:20',
            'registro_geral' => 'nullable|string|max:120',
            'orgao_emissor' => 'nullable|string|max:120',
            'data_expedicao' => 'nullable|date',
            'nome_mae' => 'nullable|string|max:100',
            'nome_pai' => 'nullable|string|max:100',
            'tipo_sanguineo' => 'nullable|string|max:5',
            'nivel_acesso' => 'nullable|integer',
            'adm_configurado' => 'nullable|integer',
        ];
    }

    public static function messages()
    {
        return [
            'data_nascimento.date' => 'O campo data de nascimento deve ser uma data válida.',
            'data_expedicao.date' => 'O campo data de nascimento deve ser uma data válida.',
            'mimes'    => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg, jpeg e .png',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',
        ];
    }
}