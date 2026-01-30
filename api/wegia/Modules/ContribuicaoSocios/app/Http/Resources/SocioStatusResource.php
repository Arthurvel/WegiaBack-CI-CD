<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocioStatusResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_sociostatus' => $this->id_sociostatus,
            'status'         => $this->status
        ];
    }
}
