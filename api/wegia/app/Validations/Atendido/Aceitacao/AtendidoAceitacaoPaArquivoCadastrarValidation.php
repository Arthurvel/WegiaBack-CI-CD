<?php

namespace app\Validations\Atendido\Aceitacao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AtendidoAceitacaoPaArquivoCadastrarValidation",
 *     type="object",
 *     required={"arquivo"},
 *     @OA\Property(
 *         property="arquivo",
 *         type="string",
 *         format="binary",
 *         description="Arquivo da aceitação (PDF ou imagem)"
 *     )
 * )
 */
class AtendidoAceitacaoPaArquivoCadastrarValidation extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_processo' => $this->route('id_processo'),
        ]);
    }

    public function rules() : array
    {
        return [
            'id_processo' => 'required|int|exists:processo_de_aceitacao,id',
            'arquivo'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120'
        ];
    }

    public function messages() : array
    {
        return [
            'required'      => 'O campo :attribute é obrigatório.',
            'int'           => 'O campo :attribute deve ser numerico.',
            'exists'        => 'O campo :attribute existir na tabela',
            'arquivo.file'  => 'Envie um arquivo válido.',
            'arquivo.mimes' => 'Formato de arquivo não permitido.',
            'arquivo.max'   => 'O arquivo deve ter no máximo 5MB.'
        ];
    }
}
