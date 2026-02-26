<?php

namespace app\Validations\Atendido\Aceitacao;

use Illuminate\Foundation\Http\FormRequest;

class AtendidoAceitacaoPaEtapaBuscarTodosValidation extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_processo' => $this->route('id_processo'),
        ]);
    }

    public function rules()
    {
        return [
            'id_processo'    => 'required|integer|exists:pa_etapa,id',
            'status'         => 'nullable|string',
            'itensPorPagina' => 'nullable|integer',
            'pagina'         => 'nullable|integer',
        ];
    }

    public function messages()
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O campo :attribute não existe.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }
}
