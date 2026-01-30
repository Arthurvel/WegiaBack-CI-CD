<?php

namespace Modules\ContribuicaoSocios\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SocioPessoaCadastrarValidation",
 *     required={"id_sociostatus","id_sociotipo","nome","cpf","telefone"},
 *
 *     @OA\Property(property="id_sociostatus", type="integer", example=1, description="Status do sócio"),
 *     @OA\Property(property="id_sociotipo", type="integer", example=2, description="Tipo do sócio"),
 *     @OA\Property(property="id_sociotag", type="integer", nullable=true, example=3, description="Tag do sócio"),
 *
 *     @OA\Property(property="email", type="string", nullable=true, example="email@teste.com", description="Email do sócio"),
 *     @OA\Property(property="valor_periodo", type="number", example=150.50, nullable=true, description="Valor pago no período"),
 *     @OA\Property(property="data_referencia", type="string", format="date", example="2025-12-01", nullable=true, description="Data de referência"),
 *
 *     @OA\Property(property="nome", type="string", example="João da Silva", description="Nome completo"),
 *     @OA\Property(property="cpf", type="string", example="123.456.789-10", description="CPF da pessoa"),
 *     @OA\Property(property="telefone", type="string", example="(11) 90000-0000", description="Telefone"),
 *     @OA\Property(property="data_nascimento", type="string", format="date", nullable=true, example="1990-05-20", description="Data de nascimento"),
 *
 *     @OA\Property(property="cep", type="string", example="01001-000", nullable=true, description="CEP"),
 *     @OA\Property(property="estado", type="string", example="SP", nullable=true, description="UF do endereço"),
 *     @OA\Property(property="cidade", type="string", example="São Paulo", nullable=true, description="Cidade"),
 *     @OA\Property(property="bairro", type="string", example="Centro", nullable=true, description="Bairro"),
 *     @OA\Property(property="logradouro", type="string", example="Rua Exemplo", nullable=true, description="Logradouro"),
 *     @OA\Property(property="numero_endereco", type="string", example="100", nullable=true, description="Número"),
 *     @OA\Property(property="complemento", type="string", example="Apartamento 12", nullable=true, description="Complemento"),
 *     @OA\Property(property="ibge", type="string", example="3550308", nullable=true, description="Código IBGE"),
 * )
 */
class SocioPessoaCadastrarValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_sociostatus' => 'required|integer|exists:socio_status,id_sociostatus',
            'id_sociotipo'   => 'required|integer|exists:socio_tipo,id_sociotipo',
            'id_sociotag'    => 'nullable|integer|exists:socio_tag,id_sociotag',
            'email'          => 'nullable|email|max:256',
            'valor_periodo'  => 'nullable|numeric|min:0',
            'data_referencia'=> 'nullable|date',

            'nome'            => 'required|string|max:100',
            'cpf'             => 'required|string|max:120|unique:pessoa,cpf',
            'telefone'        => 'required|string|max:25',
            'data_nascimento' => 'nullable|date',

            'cep'             => 'sometimes|string|max:10',
            'estado'          => 'sometimes|string|max:5',
            'cidade'          => 'sometimes|string|max:40',
            'bairro'          => 'sometimes|string|max:40',
            'logradouro'      => 'sometimes|string|max:100',
            'numero_endereco' => 'sometimes|string|max:80',
            'complemento'     => 'sometimes|string|max:50',
            'ibge'            => 'sometimes|string|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'exists'   => 'O valor informado em :attribute não existe no sistema.',
            'email'    => 'O campo :attribute deve ser um email válido.',
            'numeric'  => 'O campo :attribute deve ser numérico.',
            'date'     => 'O campo :attribute deve ser uma data válida.',
            'min'      => 'O valor de :attribute não pode ser menor que :min.',
            'max'      => 'O campo :attribute não pode exceder :max caracteres.',
            'unique'   => 'O valor informado em :attribute já está cadastrado.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'data_nascimento' => $this->data_nascimento ?: null,
        ]);
    }
}
