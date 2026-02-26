<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

class SocioRelatorioBuscarTodosParamsValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'tipo_socio'   => 'sometimes|string|in:Casual,Mensal,Bimestral,Trimestral,Semestral',
            'id_status'    => 'sometimes|integer|exists:socio_status,id_sociostatus',
            'id_tag'       => 'sometimes|integer|exists:socio_tag,id_sociotag',
            'tipo_pessoa'  => 'sometimes|string|in:f,j|max:1',
            'valor_filtro' => 'sometimes|string|in:maior,maior_igual,menor,menor_igual,igual',
            'valor'        => 'sometimes|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O valor informado em :attribute não existe no sistema.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'min'      => 'O valor de :attribute não pode ser menor que :min.',
            'in'       => 'O campo :attribute não possui essa opcao.',
        ];
    }

}
