<?php

namespace Modules\Saude\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class SaudeIntercorrenciaBuscarTodosParamsValidation extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_fichamedica' => $this->route('id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'id_fichamedica' => 'required|integer|exists:saude_fichamedica,id_fichamedica',
            'ordenacao' => 'sometimes|string|in:data',
            'tipoOrdenacao' => 'sometimes|string|in:ASC,asc,DESC,desc',
            'pagina' => 'sometimes|integer|min:1',
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
