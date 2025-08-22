<?php

namespace Modules\Pet\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="MedicamentoAtualizarValidation",
 *     @OA\Property(property="nome_medicamento", type="string", description="Nome do medicamento"),
 *     @OA\Property(property="descricao_medicamento", type="string", description="Descricao do medicamento"),
 *     @OA\Property(property="aplicacao", type="string", description="Como funciona a aplicacao"),
 * )
 */
class MedicamentoAtualizarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'nome_medicamento'      => 'sometimes|string|max:200',
            'descricao_medicamento' => 'sometimes|string|max:200',
            'aplicacao'             => 'sometimes|string|max:250',
        ];
    }

    public function messages() : array
    {
        return [
            'aplicacao.max' => 'O campo :attribute deve ter no máximo 250 caracteres',
            'nome_medicamento.max' => 'O campo :attribute deve ter no máximo 200 caracteres',
            'descricao_medicamento.max' => 'O campo :attribute deve ter no máximo 200 caracteres',
        ];
    }

}
