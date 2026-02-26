<?php

namespace app\Validations\Configuracao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ImagemEmUmCampoCadastrarValidation",
 *     @OA\Property(property="imagem", type="string", format="binary", description="Imagem de sistema (jpeg, jpg, png, máx. 5MB)"),
 *     @OA\Property(property="id_imagem", type="integer", description="id da imagem")
 * )
 */
class ImagemEmUmCampoCadastrarValidation extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_campo_imagem' => $this->route('id_campo_imagem'),
        ]);

        if ($this->id_imagem === '') {
            $this->merge(['id_imagem' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'imagem'          => 'required_without:id_imagem|nullable|file|mimes:jpg,jpeg,png|max:5120',
            'id_imagem'       => 'required_without:imagem|nullable|integer|exists:imagem,id_imagem',

            'id_campo_imagem' => 'required|integer|exists:campo_imagem,id_campo',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $temIdImagem = !empty($this->id_imagem);
            $temArquivo = $this->hasFile('imagem');

            if ($temIdImagem && $temArquivo) {
                $validator->errors()->add(
                    'id_imagem',
                    'Você deve escolher apenas uma opção: ID da imagem OU upload de arquivo'
                );
            }

            if (!$temIdImagem && !$temArquivo) {
                $validator->errors()->add(
                    'id_imagem',
                    'Você deve informar o ID da imagem ou fazer upload de uma imagem'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatorio',
            'integer'  => 'O campo :attribute deve ser inteiro',
            'exists'  => 'O campo :attribute deve ser existir na tabela'
        ];
    }

}
