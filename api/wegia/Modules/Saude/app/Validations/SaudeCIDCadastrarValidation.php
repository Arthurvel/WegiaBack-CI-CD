<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeCIDCadastrarValidation",
 *     required={"CID", "descricao"},
 *     @OA\Property(property="CID", type="string", description="codigo CID"),
 *     @OA\Property(property="descricao", type="string", description="descricao do CID"),
 * )
 */
class SaudeCIDCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'CID' => [
                'required',
                'string',
                'max:10',
                'unique:saude_tabelacid,CID',
                'regex:/^[A-Z][0-9]{2}(\.[0-9])?$/'
            ],
            'descricao'  => 'required|string|max:255',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
            'max'      => 'O campo :attribute deve conter no maximo :max caracteres.',
            'unique'   => 'O campo :attribute deve ser unico',

            'CID.regex' => 'O CID informado não é válido. Formato esperado: letra + 2 números + opcional . + número (ex: F32.0)'
        ];
    }

}
