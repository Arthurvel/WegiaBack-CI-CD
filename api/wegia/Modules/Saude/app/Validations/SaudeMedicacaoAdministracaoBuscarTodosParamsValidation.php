<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class SaudeMedicacaoAdministracaoBuscarTodosParamsValidation extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_medicacao' => $this->route('id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id_medicacao'   => 'required|integer|exists:saude_medicacao,id_medicacao',
            'pagina'         => 'sometimes|integer|min:1',
            'itensPorPagina' => 'sometimes|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser texto.',
            'exists' => 'O campo :attribute deve existir no sistema.',
            'in' => 'O campo :attribute deve respeitar as seguintes opções: :values',
            'min' => 'O campo :attribute tem valor minimo de :min.',
        ];
    }

}
