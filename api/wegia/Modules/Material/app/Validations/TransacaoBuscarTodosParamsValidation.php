<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class TransacaoBuscarTodosParamsValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'buscar'         => 'sometimes|string',
            'tipo'           => 'sometimes|string|in:e,s',
            'ordenacao'      => 'sometimes|string|in:data,descricao_almoxarifado,descricao_produto,descricao_tipo_movimentacao',
            'tipoOrdenacao'  => 'sometimes|string|in:ASC,asc,DESC,desc',
            'pagina'         => 'sometimes|integer|min:1',
            'itensPorPagina' => 'sometimes|integer|min:1',
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'string'      => 'O campo :attribute deve ser texto.',
            'exists'      => 'O campo :attribute deve existir no sistema.',
            'in' => 'O campo :attribute deve respeitar as seguintes opções: :values',
            'min' => 'O campo :attribute tem valor minimo de :min.',
        ];
    }

}
