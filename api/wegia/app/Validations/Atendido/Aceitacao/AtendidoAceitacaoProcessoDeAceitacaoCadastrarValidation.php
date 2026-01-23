<?php

namespace app\Validations\Atendido\Aceitacao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendidoAceitacaoProcessoDeAceitacaoCadastrarValidation",
 *     required={"nome", "sobrenome", "cpf"},
 *     @OA\Property(property="nome", type="string", description="nome da pessoa"),
 *     @OA\Property(property="sobrenome", type="string", description="sobrenome da pessoa"),
 *     @OA\Property(property="cpf", type="string", description="cpf da pessoa"),
 * )
 */
class AtendidoAceitacaoProcessoDeAceitacaoCadastrarValidation extends FormRequest
{
    public function rules() : array
    {
        return [
            'nome'      => 'required|string|max:100',
            'sobrenome' => 'required|string|max:100',
            'cpf'       => 'required|string|unique:pessoa,cpf|max:11',
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
