<?php

namespace app\Validations\Pessoa;


use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="PessoaAtualizarValidation",
 *     @OA\Property(property="nome", type="string", maxLength=100, nullable=true, description="Nome do usuário"),
 *     @OA\Property(property="sobrenome", type="string", maxLength=100, nullable=true, description="Sobrenome do usuário"),
 *     @OA\Property(property="sexo", type="string", maxLength=1, nullable=true, description="Sexo do usuário"),
 *     @OA\Property(property="telefone", type="string", maxLength=25, nullable=true, description="Telefone de contato"),
 *     @OA\Property(property="data_nascimento", type="string", format="date", nullable=true, description="Data de nascimento"),
 *     @OA\Property(property="cep", type="string", maxLength=10, nullable=true, description="CEP"),
 *     @OA\Property(property="estado", type="string", maxLength=5, nullable=true, description="Estado"),
 *     @OA\Property(property="cidade", type="string", maxLength=40, nullable=true, description="Cidade"),
 *     @OA\Property(property="bairro", type="string", maxLength=40, nullable=true, description="Bairro"),
 *     @OA\Property(property="logradouro", type="string", maxLength=100, nullable=true, description="Logradouro"),
 *     @OA\Property(property="numero_endereco", type="string", maxLength=80, nullable=true, description="Número do endereço"),
 *     @OA\Property(property="complemento", type="string", maxLength=50, nullable=true, description="Complemento"),
 *     @OA\Property(property="ibge", type="string", maxLength=20, nullable=true, description="Código IBGE"),
 *     @OA\Property(property="registro_geral", type="string", maxLength=120, nullable=true, description="Registro Geral (RG)"),
 *     @OA\Property(property="orgao_emissor", type="string", maxLength=120, nullable=true, description="Órgão emissor do RG"),
 *     @OA\Property(property="data_expedicao", type="string", format="date", nullable=true, description="Data de expedição do RG"),
 *     @OA\Property(property="nome_mae", type="string", maxLength=100, nullable=true, description="Nome da mãe"),
 *     @OA\Property(property="nome_pai", type="string", maxLength=100, nullable=true, description="Nome do pai"),
 *     @OA\Property(property="tipo_sanguineo", type="string", maxLength=5, nullable=true, description="Tipo sanguíneo"),
 *     @OA\Property(property="nivel_acesso", type="integer", nullable=true, description="Nível de acesso do usuário"),
 *     @OA\Property(property="adm_configurado", type="integer", nullable=true, description="Indica se o administrador está configurado")
 * )
 */
class PessoaAtualizarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'nome' => 'nullable|string|max:100',
            'sobrenome' => 'nullable|string|max:100',
            'sexo' => 'nullable|string|size:1',
            'telefone' => 'nullable|string|max:25',
            'data_nascimento' => 'nullable|date',
            'cep' => 'nullable|string|max:10',
            'estado' => 'nullable|string|max:5',
            'cidade' => 'nullable|string|max:40',
            'bairro' => 'nullable|string|max:40',
            'logradouro' => 'nullable|string|max:100',
            'numero_endereco' => 'nullable|string|max:80',
            'complemento' => 'nullable|string|max:50',
            'ibge' => 'nullable|string|max:20',
            'registro_geral' => 'nullable|string|max:120',
            'orgao_emissor' => 'nullable|string|max:120',
            'data_expedicao' => 'nullable|date',
            'nome_mae' => 'nullable|string|max:100',
            'nome_pai' => 'nullable|string|max:100',
            'tipo_sanguineo' => 'nullable|string|max:5',
            'nivel_acesso' => 'nullable|integer',
            'adm_configurado' => 'nullable|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'data_nascimento.date' => 'O campo data de nascimento deve ser uma data válida.',
            'data_expedicao.date' => 'O campo data de nascimento deve ser uma data válida.',
            'mimes'    => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg, jpeg e .png',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',
        ];
    }

}
