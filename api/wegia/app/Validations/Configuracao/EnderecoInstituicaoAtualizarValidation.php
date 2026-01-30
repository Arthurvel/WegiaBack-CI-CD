<?php

namespace app\Validations\Configuracao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="EnderecoInstituicaoAtualizarValidation",
 *     @OA\Property(property="nome", type="string", description="Nome da instituicao"),
 *     @OA\Property(property="numero_endereco", type="string", description="Numero do endereco da instituicao"),
 *     @OA\Property(property="logradouro", type="string", description="logradouro da instituicao"),
 *     @OA\Property(property="bairro", type="string", description="bairro da instituicao"),
 *     @OA\Property(property="cidade", type="string", description="cidade da instituicao"),
 *     @OA\Property(property="estado", type="string", description="estado da instituicao"),
 *     @OA\Property(property="cep", type="string", description="cep da instituicao"),
 *     @OA\Property(property="complemento", type="string", description="complemento da instituicao"),
 *     @OA\Property(property="ibge", type="string", description="ibge da instituicao")
 * )
 */
class EnderecoInstituicaoAtualizarValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'nome'            => 'required|string|max:256',
            'numero_endereco' => 'required|string|max:256',
            'logradouro'      => 'required|string|max:256',
            'bairro'          => 'required|string|max:256',
            'cidade'          => 'required|string|max:256',
            'estado'          => 'required|string|max:256',
            'cep'             => 'required|string|max:256',
            'complemento'     => 'sometimes|string|max:256',
            'ibge'            => 'required|string|max:256',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.',
            'max'      => 'O campo :attribute deve ser maior do que :max caracteres.',
        ];
    }

}
