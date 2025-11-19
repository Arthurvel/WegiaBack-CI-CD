<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeFichaMedicaAtualizarValidation",
 *     required={"prontuario"},
 *     @OA\Property(property="prontuario", type="string", description="Prontuario da pessoa")
 * )
 */
class SaudeFichaMedicaAtualizarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'prontuario'  => 'required|string'
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
        ];
    }

}
