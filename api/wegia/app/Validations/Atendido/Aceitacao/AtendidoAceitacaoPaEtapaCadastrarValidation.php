<?php

namespace app\Validations\Atendido\Aceitacao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendidoAceitacaoPaEtapaCadastrarValidation",
 *     required={"data_inicio", "id_status", "descricao"},
 *     @OA\Property(property="data_inicio", type="string", format="date", description="data de inicio"),
 *     @OA\Property(property="id_status", type="integer", description="id do status"),
 *     @OA\Property(property="descricao", type="string", description="Descricao")
 * )
 */
class AtendidoAceitacaoPaEtapaCadastrarValidation extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_processo' => $this->route('id_processo'),
        ]);
    }


    public function rules() : array
    {
        return [
            'data_inicio' => 'required|string|date_format:Y-m-d',
            'id_processo' => 'required|int|exists:processo_de_aceitacao,id',
            'id_status'   => 'required|int|exists:pa_status,id',
            'descricao'   => 'required|string|max:512'
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
