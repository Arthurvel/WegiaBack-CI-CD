<?php

namespace App\Validations\Funcionario\Perfil;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(
 *     schema="SincronizarFuncionarioPerfilPermissaoValidation",
 *     required={"permissoes"},
 *     @OA\Property(
 *         property="permissoes",
 *         type="array",
 *         @OA\Items(type="integer"),
 *         description="IDs das permissões que devem ser associadas ao perfil",
 *         example={1, 2, 3}
 *     )
 * )
 */
class SincronizarFuncionarioPerfilPermissaoValidation extends FormRequest
{
    public function rules()
    {
      return [
        'permissoes'  => 'required|array',
        'permissoes.*'=> 'integer|exists:permissao,id_permissao',
    ];
    }

    public function messages()
    {
      return [
        'array'     => 'O campo :attribute deve ser um array.',
        'integer'   => 'Cada permissão deve ser um ID válido.',
        'exists'    => 'Alguma permissão informada não existe.'
      ];
    }
}
