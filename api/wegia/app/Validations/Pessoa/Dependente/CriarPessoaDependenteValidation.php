<?php

namespace App\Validations\Pessoa\Dependente;

use App\Models\Pessoa\PessoaParentescoEnum;
use App\Rules\ValidarPessoaDependente;
use Illuminate\Validation\Rule;

class CriarPessoaDependenteValidation
{
    public static function rules($pessoaId = null)
    {
        return [
            'id_pessoa' => 'required|integer|exists:pessoa,id_pessoa',
            'id_dependente_pessoa' => [
                'required',
                'integer',
                'exists:pessoa,id_pessoa',
                new ValidarPessoaDependente($pessoaId),
            ],
            'parentesco' => [
                'required',
                Rule::in(array_column(PessoaParentescoEnum::cases(), 'value'))
            ],
        ];
    }

    public static function messages()
    {
        return [
            'required' => 'O campo é obrigatório.',
            'integer' => 'O campo deve ser um número inteiro.',
            'exists' => 'O campo deve existir na tabela.',
            'in' => 'O campo deve ser um dos seguintes valores: :values.',
        ];
    }
}