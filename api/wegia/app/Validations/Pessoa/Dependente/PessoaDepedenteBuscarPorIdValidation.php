<?php

namespace app\Validations\Pessoa\Dependente;

use Illuminate\Foundation\Http\FormRequest;

class PessoaDepedenteBuscarPorIdValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'with'           => 'nullable|string',
        ];
    }

    public function messages() : array
    {
        return [
            'string' => 'O campo deve ser uma string.',
        ];
    }

}
