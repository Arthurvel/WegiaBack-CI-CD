<?php

namespace app\Http\Resources\Atendido;

use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoStatusResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'idatendido_status' => $this->idatendido_status,
            'status'            => $this->status,
        ];
    }

}
