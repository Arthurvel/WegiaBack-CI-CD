<?php

namespace app\Validations\Pessoa;

use Illuminate\Foundation\Http\FormRequest;

class PessoaLogadaValidation extends FormRequest
{

    public function rules($pessoaId = null) : array
    {
        return [
            'with' => 'sometimes|string',
        ];
    }

    public function messages() : array
    {
        return [
            'in' => 'O campo deve respeitar os seguintes with funcionario, funcionario.situacao, funcionario.perfil, funcionario.perfil.permissoes, avisos'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('with')) {
                $allowed = [
                    'funcionario',
                    'funcionario.situacao',
                    'funcionario.perfil',
                    'funcionario.perfil.permissoes',
                    'avisos'
                ];

                $values = explode(',', $this->with);

                foreach ($values as $value) {
                    if (!in_array(trim($value), $allowed)) {
                        $validator->errors()->add('with', "O valor '$value' não é permitido.");
                    }
                }
            }
        });
    }

}
