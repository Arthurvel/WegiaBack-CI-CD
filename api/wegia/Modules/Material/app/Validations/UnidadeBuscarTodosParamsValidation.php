<?php

namespace Modules\Material\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeBuscarTodosParamsValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'buscar'         => 'sometimes|string',
            'ordenacao'      => 'sometimes|string|in:descricao',
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
