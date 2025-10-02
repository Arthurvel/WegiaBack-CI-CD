<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class SaudeAlergiaBuscarTodosParamsValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'id_fichamedica' => 'sometimes|string|exists:saude_fichamedica,id_fichamedica',
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'string'      => 'O campo :attribute deve ser texto.',
            'exists'      => 'O campo :attribute deve existir na tabela.',
        ];
    }

}
