<?php

namespace App\Validations\Pessoa\Dependente;

use App\Models\Pessoa\PessoaParentescoEnum;
use App\Rules\ValidarPessoaDependente;
use Illuminate\Validation\Rule;

class BuscarPessoaDependenteValidation
{
    public static function rules($pessoaId = null)
    {
        return [
            'id_pessoa' => 'required|integer|exists:pessoa,id_pessoa',
            'buscar' => 'nullable|string',
            'ordenacao'      => 'nullable|string|in:nome,parentesco',
            'tipoOrdenacao'  => 'nullable|string|in:asc,desc,ASC,DESC',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer'
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
