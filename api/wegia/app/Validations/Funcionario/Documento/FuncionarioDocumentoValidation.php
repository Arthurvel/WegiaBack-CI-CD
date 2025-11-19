<?php

namespace app\Validations\Funcionario\Documento;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="FuncionarioDocumentoValidation",
 *     @OA\Property(property="arquivo", type="string", format="binary", description="Arquivo a ser enviado (PDF, JPG, PNG)"),
 *     @OA\Property(property="id_docfuncional", type="integer", nullable=true, description="ID do documento funcional")
 * )
 */
class FuncionarioDocumentoValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'arquivo'         => 'required|file|mimes:pdf,jpg,png|max:5120',
            'id_docfuncional' => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'required'              => 'O campo :attribute é obrigatório.',
            'file'                  => 'O campo :attribute deve ser uma arquivo.',
            'integer'               => 'O campo :attribute deve ser um número inteiro.',
            'mimes'                 => 'O campo :attribute deve receber apenas extensões do tipo .pdf, .jpg e .png',
            'max'                   => 'O campo :attribute  deve ter no maximo 5mb'
        ];
    }

}
