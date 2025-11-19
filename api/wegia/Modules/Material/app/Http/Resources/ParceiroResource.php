<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParceiroResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_parceiro' => $this->id_parceiro,
            'nome'        => $this->nome,
            'cpf'         => $this->cpf,
            'cnpj'        => $this->cnpj,
            'telefone'    => $this->telefone
        ];
    }

}
