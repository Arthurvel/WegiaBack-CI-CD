<?php

namespace Modules\Memorando\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="MemorandoCadastrarValidation",
 *     required={"titulo", "texto", "id_destinatario"},
 *     @OA\Property(property="id_destinatario", type="string", description="id do destinatario"),
 *     @OA\Property(property="titulo", type="string", description="Título do memorando"),
 *     @OA\Property(property="texto", type="string", description="Texto do memorando"),
 *     @OA\Property(
 *          property="anexos[]",
 *          type="array",
 *          description="Arquivos opcionais (jpeg, jpg, png, máx. 5MB cada)",
 *          @OA\Items(
 *              type="string",
 *              format="binary"
 *          )
 *      )
 * )
 */
class MemorandoCadastrarValidation extends FormRequest
{
    public function rules()
    {
        return [
            'id_destinatario' => 'required|string|exists:pessoa,id_pessoa',
            'titulo'   => 'required|string',
            'texto'    => 'required|string',
            'anexos'   => 'sometimes|array',
            'anexos.*' => 'sometimes|file|mimes:jpeg,jpg,png|max:5120'
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' => 'O campo título é obrigatório.',
            'titulo.string'   => 'O campo título deve ser uma string.',

            'texto.required'  => 'O campo texto é obrigatório.',
            'texto.string'    => 'O campo texto deve ser uma string.',


            'anexos.*.file'      => 'O campo anexo deve ser um arquivo.',
            'anexos.*.mimes'     => 'O arquivo deve ser do tipo jpeg, jpg ou png.',
            'anexos.*.max'       => 'O arquivo deve ter no máximo 5MB.',

            'exists'          => 'O :attribute nao existe.'
        ];
    }
}
