<?php

namespace App\Validations\Pet;

class CriarMedicamentoValidation
{
    public static function rules()
    {
        return [
            'nome_medicamento'      => 'required|string|max:200',
            'descricao_medicamento'      => 'required|string|max:200',
            'aplicacao'      => 'required|string|max:250',
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer' => 'O campo :attribute deve ser um inteiro.',
            'exists' => 'O campo :attribute deve existir na tabela',
            'aplicacao.max' => 'O campo :attribute deve ter no máximo 250 caracteres',
            'nome_medicamento.max' => 'O campo :attribute deve ter no máximo 200 caracteres',
            'descricao_medicamento.max' => 'O campo :attribute deve ter no máximo 200 caracteres',
        ];
    }
}