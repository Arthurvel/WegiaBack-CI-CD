<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeMedicoCadastrarValidation",
 *     required={"crm", "nome"},
 *     @OA\Property(property="crm", type="string", description="crm do medico"),
 *     @OA\Property(property="nome", type="string", description="Nome do medico")
 * )
 */
class SaudeMedicoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'crm' => 'required|string|max:10|unique:saude_medicos,crm',
            'nome'  => 'required|string|max:50'
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
            'unique'   => 'O campo :attribute deve ser unico na tabela',
            'max'      => 'O campo :attribute deve ter no maximo :max caracteres'
        ];
    }

}
