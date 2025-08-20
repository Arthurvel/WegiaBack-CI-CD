<?php

namespace App\Validations\Aviso;

use Illuminate\Foundation\Http\FormRequest;

class AvisoBuscarTodosValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'ativo'          => 'nullable|string|in:true,false',
            'titulo'         => 'nullable|string',
            'nivel'          => 'nullable|string|in:info,alerta,erro',
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
