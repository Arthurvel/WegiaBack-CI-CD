<?php

namespace app\Http\Resources\Configuracao;

use Illuminate\Http\Resources\Json\JsonResource;

class ContatoInstituicaoResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id'        => $this->id,
            'descricao' => $this->descricao,
            'contato'   => $this->contato
        ];
    }
}
