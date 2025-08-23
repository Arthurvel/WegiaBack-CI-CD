<?php

namespace App\Validations\Funcionario;

use Illuminate\Validation\Rule;

class CriarFuncionarioValidation
{
    public static function rules()
    {
        return [
            'cpf' => 'required|string|max:11',
            'nome' => 'required|string|max:100',
            'sobrenome' => 'required|string|max:100',
            'sexo' => 'required|string|size:1',
            'telefone' => 'required|string|max:25',
            'data_nascimento' => 'required|date',
            'imagem' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'registro_geral' => 'required|string|max:120',
            'orgao_emissor' => 'required|string|max:120',
            'data_expedicao' => 'required|date',

            'data_admissao' => 'required|date',
            'id_situacao' => 'required|integer|max:11|exists:situacao,id_situacao',
            'id_perfil' => 'required|integer|max:11|exists:perfil,id_perfil',
            'id_escala' => 'required|integer|max:11|exists:escala_quadro_horario,id_escala',
            'id_tipo' => 'required|integer|max:11|exists:tipo_quadro_horario,id_tipo',
            'certificado_reservista_numero' => 'nullable|string|max:100',
            'certificado_reservista_serie' => 'nullable|string|max:100',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.',
            'file'     => 'O campo :attribute deve ser um arquivo.',
            'max'      => 'O campo :attribute não pode ter mais de :max caracteres.',
            'date'     => 'O campo :attribute deve ser uma data válida.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'size'     => 'O campo :attribute deve ter exatamente :size caracteres.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
            'mimes'    => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg, jpeg e .png',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',

            'cpf.unique' => 'Este CPF já está em uso.',
            'data_nascimento.date' => 'O campo data de nascimento deve ser uma data válida.',
            'data_admissao.date' => 'O campo data de admissão deve ser uma data válida.',
            'data_expedicao.date' => 'O campo data de expedição deve ser uma data válida.',
        ];
    }
}
