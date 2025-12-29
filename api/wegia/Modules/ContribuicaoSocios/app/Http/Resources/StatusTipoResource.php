<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusTipoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_sociotipo' => $this->id_sociotipo,
            'tipo'         => $this->tipo
        ];
    }
}
