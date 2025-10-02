<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class SaudeFichaMedicaParamsValidation extends FormRequest
{
    public function rules() : array
    {
        return [
            'buscar'       => 'nullable|string',
            'ordenacao'    => 'nullable|string|in:nome',
            'tipoOrdenacao' => 'nullable|string|in:ASC,asc,DESC,desc',
            'pagina'       => 'nullable|integer|min:1',
            'itensPorPagina'=> 'nullable|integer|min:1',
        ];
    }

    public function messages() : array
    {
        return [
            'string'  => 'O campo :attribute deve ser texto.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'min'     => 'O campo :attribute deve ser no mínimo :min.',
            'in'      => 'O valor do campo :attribute não é válido.',
        ];
    }
}
