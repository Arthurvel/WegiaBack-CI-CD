<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SocioPublicoResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id_pessoa'       => $this->id_pessoa,
            'id_socio'        => $this->socio ? $this->socio->id_socio: null,
            'cpf'             => $this->cpf,
            'nome'            => $this->nome,
            'telefone'        => $this->telefone,
            'data_nascimento' => $this->data_nascimento ?
                Carbon::parse($this->data_nascimento)->format('d/m/Y') : '',
            'email'           => $this->socio ? $this->socio->email : null,
            'cep'             => $this->cep,
            'estado'          => $this->estado,
            'cidade'          => $this->cidade,
            'bairro'          => $this->bairro,
            'logradouro'      => $this->logradouro,
            'numero_endereco' => $this->numero_endereco,
            'complemento'     => $this->complemento,
            'ibge'            => $this->ibge
        ];
    }
}
