<?php

namespace Modules\Pet\app\Validations;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FichaMedicaAtualizarValidation",
 *     @OA\Property(property="castrado", type="string", description="castrado", enum={"s", "n"}),
 *     @OA\Property(property="necessidades_especiais", type="string", description="Necessidades especiais")
 * )
 */
class FichaMedicaAtualizarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'castrado'                => 'sometimes|string|max:1|in:s,n',
            'necessidades_especiais'  => 'sometimes|string|max:255'
        ];
    }

    public function messages() : array
    {
        return [
            'string'   => 'O campo :attribute deve ser uma string.',
            'castrado.max'  => 'O campo :attribute deve ter no máximo 1 caracter.',
            'necessidades_especiais.max'  => 'O campo :attribute deve ter no máximo 255 caracter.',
            'in' => 'O campo :attribute deve ser s ou n.',
        ];
    }

}

