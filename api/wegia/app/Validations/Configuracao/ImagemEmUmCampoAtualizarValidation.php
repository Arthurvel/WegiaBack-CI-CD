<?php

namespace app\Validations\Configuracao;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="ImagemEmUmCampoAtualizarValidation",
 *     @OA\Property(property="imagem", type="string", format="binary", description="Imagem de sistema (jpeg, jpg, png, máx. 5MB)"),
 *     @OA\Property(property="id_imagem_nova", type="integer", description="id da nova imagem")
 * )
 */
class ImagemEmUmCampoAtualizarValidation extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id_imagem'       => $this->route('id_imagem'),
            'id_campo_imagem' => $this->route('id_campo_imagem'),
        ]);

        if ($this->id_imagem_nova === '') {
            $this->merge(['id_imagem_nova' => null]);
        }
    }

    public function rules(): array
    {
        return [
            'id_imagem'       => 'required|integer|exists:imagem,id_imagem',
            'id_campo_imagem' => 'required|integer|exists:campo_imagem,id_campo',

            'id_imagem_nova'  => 'required_without:imagem|nullable|integer|exists:imagem,id_imagem',
            'imagem'          => 'required_without:id_imagem_nova|nullable|file|mimes:jpg,jpeg,png|max:5120'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $temIdImagem = !empty($this->id_imagem_nova);
            $temArquivo = $this->hasFile('imagem');

            if ($temIdImagem && $temArquivo) {
                $validator->errors()->add(
                    'id_imagem_nova',
                    'Você deve escolher apenas uma opção: ID da imagem OU upload de arquivo'
                );
            }

            if (!$temIdImagem && !$temArquivo) {
                $validator->errors()->add(
                    'id_imagem_nova',
                    'Você deve informar o ID da imagem ou fazer upload de uma imagem'
                );
            }
        });
    }

    public function messages(): array
    {
        return [
            'required'         => 'O campo :attribute é obrigatorio',
            'integer'          => 'O campo :attribute deve ser inteiro',
            'exists'           => 'O campo :attribute deve ser existir na tabela',
            'required_without' => 'O campo id_imagem_nova ou imagem deve ser preenchido'
        ];
    }

}
