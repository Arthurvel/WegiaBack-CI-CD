<?php

namespace Modules\Pet\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AdocaoCadastrarValidation",
 *     required={"data_adocao", "id_pessoa"},
 *     @OA\Property(property="data_adocao", type="string", format="date", description="Data da adoção"),
 *     @OA\Property(property="id_pessoa", type="integer", description="id da pessoa")
 * )
 */
class AdocaoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'data_adocao' => 'required|date_format:Y-m-d',
            'id_pessoa'   => 'required|integer|exists:pessoa,id_pessoa',
        ];
    }

    public function messages() : array
    {
        return [
            'date_format' => 'O campo :attribute deve uma data no formato Y-m-d.',
            'required'    => 'Campo :attribute obrigatorio',
            'exists'      => 'O campo :attribute nao existe'
        ];
    }

}
