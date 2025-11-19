<?php

namespace app\Http\Resources\Atendido;

use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoTipoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'idatendido_tipo' => $this->idatendido_tipo,
            'descricao'       => $this->descricao,
        ];
    }

}
