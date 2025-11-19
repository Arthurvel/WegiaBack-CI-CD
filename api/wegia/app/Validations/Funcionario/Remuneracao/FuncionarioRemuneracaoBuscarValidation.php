<?php

namespace app\Validations\Funcionario\Remuneracao;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioRemuneracaoBuscarValidation extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'id_funcionario' => $this->route('id_funcionario'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_funcionario' => 'sometimes|integer|exists:funcionario,id_funcionario',
            'buscar'         => 'sometimes|string',
            'ordenacao'      => 'sometimes|string',
            'tipoOrdenacao'  => 'sometimes|string',
            'itensPorPagina' => 'sometimes|integer',
            'pagina'         => 'sometimes|integer'
        ];
    }

    public function messages() : array
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O campo :attribute não existe.',
            'required' => 'O campo :attribute é obrigatório.',
        ];
    }

}
