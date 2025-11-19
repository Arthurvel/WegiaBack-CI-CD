<?php

namespace app\Validations\Funcionario\Documento;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FuncionarioDocumentoTipoCadastrarValidation",
 *     required={"nome_docfuncional"},
 *     @OA\Property(property="nome_docfuncional", type="string", description="Nome do documento"),
 *     @OA\Property(property="descricao_docfuncional", type="string", nullable=true, description="Descricao do documento")
 * )
 */
class FuncionarioDocumentoTipoCadastrarValidation extends FormRequest
{

    public function rules() : array
    {
        return [
            'nome_docfuncional'       => 'required|string|max:50',
            'descricao_docfuncional'  => 'nullable|string|max:256'
        ];
    }

    public function messages() : array
    {
        return [
            'required'              => 'O campo :attribute é obrigatório.',
            'max'                   => 'O campo :attribute  deve ter no maximo 5mb'
        ];
    }

}
