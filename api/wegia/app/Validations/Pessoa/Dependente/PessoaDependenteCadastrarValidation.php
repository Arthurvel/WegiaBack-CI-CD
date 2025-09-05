<?php

namespace App\Validations\Pessoa\Dependente;

use App\Models\Pessoa\PessoaParentescoEnum;
use App\Rules\ValidarPessoaDependente;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="PessoaDependenteCadastrarValidation",
 *     required={"parentesco"},
 *     @OA\Property(
 *                  property="parentesco",
 *                  type="string",
 *                  description="Tipo de parentesco",
 *                  enum={
 *                      "Companheiro(a)",
 *                      "Cônjuge",
 *                      "Enteado(a)",
 *                      "Ex-cônjuge",
 *                      "Filho(a)",
 *                      "Irmão(ã)",
 *                      "Neto(a)",
 *                      "Pais",
 *                      "Outra relação de dependência"
 *                  }
 *      )
 * )
 */
class PessoaDependenteCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'parentesco' => [
                'required',
                Rule::in(array_column(PessoaParentescoEnum::cases(), 'value'))
            ],
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo é obrigatório.',
            'integer' => 'O campo deve ser um número inteiro.',
            'exists' => 'O campo deve existir na tabela.',
            'in' => 'O campo deve ser um dos seguintes valores: :values.',
        ];
    }

}
