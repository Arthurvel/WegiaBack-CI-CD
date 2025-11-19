<?php

namespace app\Validations\Funcionario;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioBuscarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'id_situacao'    => 'sometimes|integer',
            'buscar'         => 'sometimes|string',
            'ordenacao'      => 'sometimes|string',
            'tipoOrdenacao'  => 'sometimes|string|in:ASC,asc,DESC,desc',
            'itensPorPagina' => 'sometimes|integer',
            'pagina'         => 'sometimes|integer'
        ];
    }

    public function messages() : array
    {
        return [
            'string' => 'O campo :attribute deve ser uma string.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
        ];
    }

}
