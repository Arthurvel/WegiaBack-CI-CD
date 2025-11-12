<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class SaudeFichaMedicaAlergiaCadastrarValidation extends FormRequest
{

    protected function prepareForValidation() : void
    {
        $this->merge([
            'id_fichamedica' => $this->route('id_fichamedica'),
            'id_alergia' => $this->route('id_alergia'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_fichamedica'   => 'required|integer|exists:saude_fichamedica,id_fichamedica',
            'id_alergia'   => 'required|integer|exists:saude_alergia,id_alergia',
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'exists'      => 'O campo :attribute deve existir',
        ];
    }

}
