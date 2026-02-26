<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class SocioPessoaBuscarPorCPFValidation extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpfCnpj' => $this->route('cpfCnpj'),
        ]);
    }

    public function rules(): array
    {
        return [
            'cpfCnpj' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'  => 'O campo :attribute deve ser uma string.',
            'exists'   => 'O valor informado em :attribute não existe no sistema.'
        ];
    }

}
