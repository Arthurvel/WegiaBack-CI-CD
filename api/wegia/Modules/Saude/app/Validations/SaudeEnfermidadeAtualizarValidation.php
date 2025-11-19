<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeEnfermidadeAtualizarValidation",
 *     @OA\Property(property="status", type="integer", enum={0,1}, description="Status da enfermidade"),
 *     @OA\Property(property="data_diagnostico", type="string", description="descricao do CID"),
 * )
 */
class SaudeEnfermidadeAtualizarValidation extends FormRequest
{
    protected function prepareForValidation() : void
    {
        $this->merge([
            'id_enfermidade' => $this->route('id'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_enfermidade'   => 'required|integer|exists:saude_enfermidades,id_enfermidade',
            'status'            => 'sometimes|integer|in:0,1',
            'data_diagnostico' => 'sometimes|string|date_format:Y-m-d',
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'string'      => 'O campo :attribute deve ser texto.',
            'exists'      => 'O campo :attribute deve existir no sistema.',
            'in' => 'O campo :attribute deve respeitar as seguintes opções: :values',
            'date_format' => 'O campo :attribute deve ser no formato YYYY-mm-dd'
        ];
    }
}
