<?php

namespace App\Validations\Atendido;

class CriarAtendido
{
    public static function rules()
    {
        return [
            'pessoa_id_pessoa' => 'required|int|exists:pessoa,id_pessoa',
            'atendido_tipo_idatendido_tipo' => 'required|int|exists:atendido_tipo,idatendido_tipo',
            'atendido_status_idatendido_status' => 'required|int|exists:atendido_status,idatendido_status',
        ];
    }

    public static function messages()
    {
        return [
            'exists'   => 'O campo :attribute não existe na tabela correspondente.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }
}