<?php

namespace app\Validations\Funcionario;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FuncionarioAtualizarValidation",
 *     @OA\Property(property="id_perfil", type="integer", description="ID do perfil"),
 *     @OA\Property(property="id_situacao", type="integer", description="ID da situação"),
 *     @OA\Property(property="data_admissao", type="string", format="date", description="Data de admissão"),
 *     @OA\Property(property="ctps", type="string", maxLength=150, description="Carteira de Trabalho"),
 *     @OA\Property(property="pis", type="string", maxLength=140, description="Número do PIS"),
 *     @OA\Property(property="uf_ctps", type="string", maxLength=20, description="UF da CTPS"),
 *     @OA\Property(property="numero_titulo", type="string", maxLength=150, description="Número do título de eleitor"),
 *     @OA\Property(property="zona", type="string", maxLength=30, description="Zona eleitoral"),
 *     @OA\Property(property="secao", type="string", maxLength=40, description="Seção eleitoral"),
 *     @OA\Property(property="certificado_reservista_numero", type="string", maxLength=100, description="Número do certificado de reservista"),
 *     @OA\Property(property="certificado_reservista_serie", type="string", maxLength=100, description="Série do certificado de reservista")
 * )
 */
class FuncionarioAtualizarValidation extends FormRequest
{
    public function rules(): array
    {
        return [
            'id_perfil' => 'nullable|integer|exists:perfil,id_perfil',
            'id_situacao' => 'nullable|integer|exists:situacao,id_situacao',
            'data_admissao' => 'nullable|date',
            'ctps' => 'nullable|string|max:150',
            'pis' => 'nullable|string|max:140',
            'uf_ctps' => 'nullable|string|max:20',
            'numero_titulo' => 'nullable|string|max:150',
            'zona' => 'nullable|string|max:30',
            'secao' => 'nullable|string|max:40',
            'certificado_reservista_numero' => 'nullable|string|max:100',
            'certificado_reservista_serie' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'date' => 'O campo :attribute deve ser uma data válida.',
            'string' => 'O campo :attribute deve ser uma string.',
            'max' => 'O campo :attribute não pode ter mais de :max caracteres.',
            'exists' => 'O campo :attribute deve existir na tabela correspondente.',
        ];
    }
}
