<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SaudeEnfermidadeCadastrarValidation",
 *     required={"id_CID", "status"},
 *     @OA\Property(property="id_CID", type="integer", description="codigo CID"),
 *     @OA\Property(property="data_diagnostico", type="string", description="descricao do CID"),
 *     @OA\Property(property="status", type="integer", enum={0,1}, description="Status da enfermidade"),
 * )
 */
class SaudeEnfermidadeCadastrarValidation extends FormRequest
{

    protected function prepareForValidation() : void
    {
        $this->merge([
            'id_fichamedica' => $this->route('id'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_fichamedica'   => 'required|integer|exists:saude_fichamedica,id_fichamedica',
            'id_CID'           => 'required|integer|exists:saude_tabelacid,id_CID',
            'data_diagnostico' => 'sometimes|string|date_format:Y-m-d',
            'status'           => 'required|integer|in:0,1',
        ];
    }

    public function messages() : array
    {
        return [
            'required'    => 'O campo :attribute é obrigatório.',
            'string'      => 'O campo :attribute deve ser texto.',
            'exists'      => 'O campo :attribute deve existir no sistema.',
            'date_format' => 'O campo :attribute deve ser no formato YYYY-mm-dd',
            'in' => 'O campo :attribute deve respeitar as seguintes opções: :values',
        ];
    }

}
