<?php

namespace app\Http\Resources\Configuracao;

use Illuminate\Http\Resources\Json\JsonResource;

class EnderecoInstituicaoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_inst'         => $this->id_inst ?? '',
            'nome'            => $this->nome ?? '',
            'numero_endereco' => $this->numero_endereco ?? '',
            'logradouro'      => $this->logradouro ?? '',
            'bairro'          => $this->bairro ?? '',
            'cidade'          => $this->cidade ?? '',
            'estado'          => $this->estado ?? '',
            'cep'             => $this->cep ?? '',
            'complemento'     => $this->complemento ?? '',
            'ibge'            => $this->ibge ?? '',
        ];
    }

}
