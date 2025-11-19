<?php

namespace app\Validations\Funcionario\infos;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="FuncionarioInfosCadastrarValidation",
 *     @OA\Property(property="dado", type="string", maxLength=255, description="Dados a serem cadastrados")
 * )
 */
class FuncionarioInfosCadastrarValidation extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'id_funcionario' => $this->route('id_funcionario'),
            'id_funcionario_lista_info' => $this->route('id_funcionario_lista_info'),
        ]);
    }

    public static function rules() : array
    {
        return [
            'id_funcionario' => 'required|integer|exists:funcionario,id_funcionario',
            'id_funcionario_lista_info' => 'required|integer|exists:funcionario_listainfo,idfuncionario_listainfo',
            'dado' => 'required|string|max:255',
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'max'      => 'O campo :attribute pode ter no maximo 255 caracteres.',
            'unique'   => 'O campo :attribute já está cadastrado.',
            'exists'   => 'O campo :attribute deve existir na tabela correspondente'
        ];
    }

}
