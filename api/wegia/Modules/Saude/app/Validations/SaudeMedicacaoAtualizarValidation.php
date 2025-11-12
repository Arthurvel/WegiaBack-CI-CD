<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeMedicacaoAtualizarValidation",
 *     required={"status"},
 *     @OA\Property(
 *      property="status",
 *      type="string",
 *      description="status da medicacao",
 *      enum={"Tratamento", "Concluído", "Substituido", "Cancelado"}
 *     ),
 * )
 */
class SaudeMedicacaoAtualizarValidation extends FormRequest
{

    protected function prepareForValidation() : void
    {
        $this->merge([
            'id_medicacao' => $this->route('id'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_medicacao' => 'required|integer|exists:saude_medicacao,id_medicacao',
            'status'       => 'required|string|in:Tratamento,Concluido,Substituido,Cancelado',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
            'exists'      => 'O campo :attribute deve existir',
            'in'       => 'O campo :attribute deve possuir um dos seguintes valores: Tratamento, Concluido, Substituido, Cancelado.'
        ];
    }

}
