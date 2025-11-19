<?php

namespace Modules\Pet\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class MedicamentoBuscarTodosValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            'buscar'         => 'sometimes|string',
            'ordenacao'      => 'sometimes|string|in:nome_medicamento',
            'tipoOrdenacao'  => 'sometimes|string|in:ASC,asc,DESC,desc',
            'pagina'         => 'sometimes|integer|min:1',
            'itensPorPagina' => 'sometimes|integer|min:1',
        ];
    }

    public function messages() : array
    {
        return [
            'string' => 'O campo :attribute deve ser um texto.',
            'integer' => 'O campo :attribute deve ser um inteiro.',
            'boolean' => 'O campo :attribute deve ser um booleano.',
            'in' => 'O campo :attribute deve respeitar as seguintes opções: :values',
            'min' => 'O campo :attribute tem valor minimo de :min.',
        ];
    }
}
