<?php

namespace app\Validations\Funcionario;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FuncionarioCadastrarValidation",
 *     required={
 *         "cpf", "nome", "sobrenome", "sexo", "telefone",
 *         "data_nascimento", "registro_geral", "orgao_emissor",
 *         "data_expedicao", "data_admissao", "id_situacao",
 *         "id_perfil", "id_escala", "id_tipo"
 *     },
 *     @OA\Property(property="cpf", type="string", maxLength=11, description="CPF do funcionário (somente números)"),
 *     @OA\Property(property="nome", type="string", maxLength=100, description="Nome do funcionário"),
 *     @OA\Property(property="sobrenome", type="string", maxLength=100, description="Sobrenome do funcionário"),
 *     @OA\Property(property="sexo", type="string", enum={"M","F"}, description="Sexo do funcionário (M ou F)"),
 *     @OA\Property(property="telefone", type="string", maxLength=25, description="Telefone do funcionário"),
 *     @OA\Property(property="data_nascimento", type="string", format="date", description="Data de nascimento do funcionário (YYYY-MM-DD)"),
 *     @OA\Property(property="imagem", type="string", format="binary", description="Foto do funcionário (jpg, jpeg, png, máx. 5MB)"),
 *     @OA\Property(property="registro_geral", type="string", maxLength=120, description="Número do RG do funcionário"),
 *     @OA\Property(property="orgao_emissor", type="string", maxLength=120, description="Órgão emissor do RG"),
 *     @OA\Property(property="data_expedicao", type="string", format="date", description="Data de expedição do RG (YYYY-MM-DD)"),
 *     @OA\Property(property="data_admissao", type="string", format="date", description="Data de admissão do funcionário (YYYY-MM-DD)"),
 *     @OA\Property(property="id_situacao", type="integer", description="ID da situação do funcionário"),
 *     @OA\Property(property="id_perfil", type="integer", description="ID do perfil do funcionário"),
 *     @OA\Property(property="id_escala", type="integer", description="ID da escala do funcionário"),
 *     @OA\Property(property="id_tipo", type="integer", description="ID do tipo de quadro horário do funcionário"),
 *     @OA\Property(property="certificado_reservista_numero", type="string", maxLength=100, description="Número do certificado de reservista (se aplicável)"),
 *     @OA\Property(property="certificado_reservista_serie", type="string", maxLength=100, description="Série do certificado de reservista (se aplicável)")
 * )
 */
class FuncionarioCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'cpf' => 'required|string|max:11',
            'nome' => 'required|string|max:100',
            'sobrenome' => 'required|string|max:100',
            'sexo' => 'required|string|size:1',
            'telefone' => 'required|string|max:25',
            'data_nascimento' => 'required|date',
            'imagem' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'registro_geral' => 'required|string|max:120',
            'orgao_emissor' => 'required|string|max:120',
            'data_expedicao' => 'required|date',

            'data_admissao' => 'required|date',
            'id_situacao' => 'required|integer|max:11|exists:situacao,id_situacao',
            'id_perfil' => 'required|integer|max:11|exists:perfil,id_perfil',
            'id_escala' => 'required|integer|max:11|exists:escala_quadro_horario,id_escala',
            'id_tipo' => 'required|integer|max:11|exists:tipo_quadro_horario,id_tipo',
            'certificado_reservista_numero' => 'nullable|string|max:100',
            'certificado_reservista_serie' => 'nullable|string|max:100',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.',
            'file'     => 'O campo :attribute deve ser um arquivo.',
            'max'      => 'O campo :attribute não pode ter mais de :max caracteres.',
            'date'     => 'O campo :attribute deve ser uma data válida.',
            'integer'  => 'O campo :attribute deve ser um número inteiro.',
            'size'     => 'O campo :attribute deve ter exatamente :size caracteres.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
            'mimes'    => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg, jpeg e .png',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',

            'cpf.unique' => 'Este CPF já está em uso.',
            'data_nascimento.date' => 'O campo data de nascimento deve ser uma data válida.',
            'data_admissao.date' => 'O campo data de admissão deve ser uma data válida.',
            'data_expedicao.date' => 'O campo data de expedição deve ser uma data válida.',
        ];
    }

}
