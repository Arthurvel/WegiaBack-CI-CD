<?php

namespace App\Validations\Funcionario;

class CriarQuadroHorarioFuncionarioValidation
{
    public static function rules()
    {
        return [
            'id_funcionario'   => 'required|integer|exists:funcionario,id_funcionario',
            'id_escala'        => 'required|integer|exists:escala_quadro_horario,id_escala',
            'id_tipo'          => 'required|integer|exists:tipo_quadro_horario,id_tipo',
            'carga_horaria'    => 'nullable|string|max:200',
            'entrada1'         => 'nullable|string|max:200',
            'saida1'           => 'nullable|string|max:200',
            'entrada2'         => 'nullable|string|max:200',
            'saida2'           => 'nullable|string|max:200',
            'total'            => 'nullable|string|max:200',
            'dias_trabalhados' => 'nullable|string|max:200',
            'folga'            => 'nullable|string|max:200',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute pode ter no maximo 255 caracteres.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
            'integer'  => 'O campo :attribute deve ser um número inteiro',
            'string'     => 'O campo :attribute deve ser uma string',
        ];
    }
}