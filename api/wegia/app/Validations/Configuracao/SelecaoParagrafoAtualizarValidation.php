<?php

namespace app\Validations\Configuracao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="SelecaoParagrafoAtualizarValidation",
 *     @OA\Property(property="paragrafo", type="string", description="texto do paragrafo")
 * )
 */
class SelecaoParagrafoAtualizarValidation extends FormRequest
{

    public function rules(): array
    {
        return [
            'paragrafo' => 'required|string'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser uma string.'
        ];
    }

}
