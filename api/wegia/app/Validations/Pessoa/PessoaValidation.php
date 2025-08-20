<?php

namespace App\Validations\Pessoa;

use Illuminate\Validation\Rule;

class PessoaValidation
{
    public static function rules($pessoaId = null)
    {
        return [
            'cpf' => [
                'required',
                'string',
                'max:11',
                Rule::unique('pessoa', 'cpf')->ignore($pessoaId, 'id_pessoa'),
            ],
            'senha' => 'nullable|string|max:70',
            'nome' => 'nullable|string|max:100',
            'sobrenome' => 'nullable|string|max:100',
            'sexo' => 'nullable|string|size:1',
            'telefone' => 'nullable|string|max:25',
            'data_nascimento' => 'nullable|date',
            'imagem' => 'nullable|string',
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
            'required' => 'O campo é obrigatório.',
            'cpf.unique' => 'Este CPF já está em uso.',
            'data_nascimento.date' => 'O campo data de nascimento deve ser uma data válida.',

        ];
    }
}