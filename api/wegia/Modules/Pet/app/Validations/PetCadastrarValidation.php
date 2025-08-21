<?php

namespace Modules\Pet\app\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Pet\app\Enums\PetCorEnum;

/**
 * @OA\Schema(
 *     schema="PetCadastrarValidation",
 *     required={"nome", "data_nascimento", "data_acolhimento", "sexo", "id_pet_especie", "id_pet_raca", "cor"},
 *     @OA\Property(property="nome", type="string", description="Nome do pet"),
 *     @OA\Property(property="data_nascimento", type="string", format="date", description="Data de nascimento do pet (YYYY-MM-DD)"),
 *     @OA\Property(property="data_acolhimento", type="string", format="date", description="Data de acolhimento do pet (YYYY-MM-DD)"),
 *     @OA\Property(property="sexo", type="string", enum={"M","F"}, description="Sexo do pet (M ou F)"),
 *     @OA\Property(property="caracteristicas_especificas", type="string", description="Características específicas do pet"),
 *     @OA\Property(property="foto", type="string", format="binary", description="Arquivo da foto do pet (jpeg, jpg, png, máx. 5MB)"),
 *     @OA\Property(property="id_pet_especie", type="integer", description="ID da espécie do pet"),
 *     @OA\Property(property="id_pet_raca", type="integer", description="ID da raça do pet"),
 *     @OA\Property(property="cor", type="string", description="Cor do pet", enum={
 *         "Preto", "Branco", "Cinza", "Marrom", "Caramelo", "Amarelo", "Bege", "Dourado", "Ruivo", "Creme", "Azul", "Chocolate", "Bicolor", "Tricolor"
 *     })
 * )
 */
class PetCadastrarValidation extends FormRequest
{
    public function rules() : array
    {
        return [
            'nome'                       => 'required|string|max:200',
            'data_nascimento'            => 'required|date',
            'data_acolhimento'           => 'required|date',
            'sexo'                       => 'required|string|in:M,F',
            'caracteristicas_especificas'=> 'nullable|string|max:250',

            'foto'                       => 'sometimes|file|mimes:jpeg,jpg,png|max:5120',

            'id_pet_especie'             => 'required|integer|exists:pet_especie,id_pet_especie',
            'id_pet_raca'                => 'required|integer|exists:pet_raca,id_pet_raca',
            'cor'                        => 'required|string|in:' . implode(',', PetCorEnum::values()),
        ];
    }

    public function messages() : array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string'   => 'O campo :attribute deve ser texto.',
            'integer'  => 'A :attribute deve ser um número.',
            'max'      => 'O campo :attribute deve ter no máximo :max caracteres.',
            'date'     => 'A :attribute deve estar no formato válido (YYYY-MM-DD).',
            'exists'   => 'O :attribute informada não existe.',
            'in'       => 'A :attribute deve ser uma das opções válidas.',

            'sexo.in'       => 'O sexo deve ser M (macho) ou F (fêmea).',

            'foto.file'     => 'O arquivo enviado deve ser uma foto.',
            'foto.mimes'    => 'A foto deve ser do tipo jpeg, jpg ou png.',
            'foto.max'      => 'A foto deve ter no máximo 5MB.',


        ];
    }
}
