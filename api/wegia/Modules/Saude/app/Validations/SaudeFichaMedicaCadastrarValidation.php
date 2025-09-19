<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeFichaMedicaCadastrarValidation",
 *     required={"id_pessoa", "prontuario"},
 *     @OA\Property(property="id_pessoa", type="string", description="id da pessoa"),
 *     @OA\Property(property="prontuario", type="string", description="Prontuario da pessoa")
 * )
 */
class SaudeFichaMedicaCadastrarValidation extends FormRequest
{
    public function rules() : array
    {
        return [
            'id_pessoa' => 'required|integer|exists:pessoa,id_pessoa|unique:saude_fichamedica,id_pessoa',
            'prontuario'  => 'required|string'
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
            'exists'   => 'O :attribute informada não existe.',
        ];
    }
}

