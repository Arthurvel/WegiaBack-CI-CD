<?php

namespace app\Http\Resources\Atendido\Aceitacao;

use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoAceitacaoPaStatusResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'        => $this->id,
            'descricao' => $this->descricao
        ];
    }
}

