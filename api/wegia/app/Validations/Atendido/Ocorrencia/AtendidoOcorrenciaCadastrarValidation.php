<?php

namespace App\Validations\Atendido\Ocorrencia;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendidoOcorrenciaCadastrarValidation",
 *     @OA\Property(property="arquivo", type="string", format="binary", description="Arquivo a ser enviado (PDF, JPG, PNG)"),
 *     @OA\Property(property="atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos", type="integer", description="ID do tipo do atendido"),
 *     @OA\Property(property="funcionario_id_funcionario", type="integer", description="ID do funcionario que esta atendendo"),
 *     @OA\Property(property="data", type="string", format="date", description="Data da ocorrencia"),
 *     @OA\Property(property="descricao", type="string", description="Descricao da ocorrencia"),
 * )
 */
class AtendidoOcorrenciaCadastrarValidation extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'id_atendido' => $this->route('id')
        ]);
    }

    public function rules() : array
    {
        return [
            'id_atendido' => 'required|int|exists:atendido,idatendido',
            'imagem' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos' => 'required|int|exists:atendido_ocorrencia_tipos,idatendido_ocorrencia_tipos',
            'funcionario_id_funcionario' => 'required|int|exists:funcionario,id_funcionario',
            'data' => 'required|date',
            'descricao' => 'required|string|max:255',
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
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
            'mimes'    => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg, jpeg e .png',
            'max'      => 'O campo :attribute  deve ter no maximo 5mb',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente',
        ];
    }
}
