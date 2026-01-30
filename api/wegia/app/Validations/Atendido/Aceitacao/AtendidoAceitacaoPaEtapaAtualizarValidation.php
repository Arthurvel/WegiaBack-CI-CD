<?php

namespace app\Validations\Atendido\Aceitacao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendidoAceitacaoPaEtapaAtualizarValidation",
 *     @OA\Property(property="data_inicio", type="string", format="date", description="data de inicio"),
 *     @OA\Property(property="data_fim", type="string", format="date", description="data de termino"),
 *     @OA\Property(property="id_status", type="integer", description="id do status"),
 *     @OA\Property(property="descricao", type="string", description="Descricao")
 * )
 */
class AtendidoAceitacaoPaEtapaAtualizarValidation extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_etapa' => $this->route('id_etapa'),
        ]);
    }


    public function rules() : array
    {
        return [
            'data_inicio' => 'sometimes|string|date_format:Y-m-d',
            'data_fim'    => 'sometimes|string|date_format:Y-m-d',
            'id_etapa'    => 'required|integer|exists:pa_etapa,id',
            'id_status'   => 'sometimes|int|exists:pa_status,id',
            'descricao'   => 'sometimes|string|max:512'
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
            'unique'   => 'O campo :attribute deve ser unico',
            'max'      => 'O campo :attribute deve possir no maximo :max caracteres.',
        ];
    }
}
