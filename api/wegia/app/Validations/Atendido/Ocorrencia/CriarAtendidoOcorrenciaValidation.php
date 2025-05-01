<?php

namespace App\Validations\Atendido\Ocorrencia;

class CriarAtendidoOcorrenciaValidation
{
    public static function rules()
    {
        return [
            'id_atendido' => 'required|int|exists:atendido,idatendido',
            'imagem' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos' => 'required|int|exists:atendido_ocorrencia_tipos,idatendido_ocorrencia_tipos',
            'funcionario_id_funcionario' => 'required|int|exists:funcionario,id_funcionario',
            'data' => 'required|date',
            'descricao' => 'required|string|max:255',
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
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
            'mimes'    => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg, jpeg e .png',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
        ];
    }
}