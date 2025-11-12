<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContribuicaoMeioPagamentoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'            => $this->id,
            'id_plataforma' => $this->id_plataforma,
            'meio'          => $this->meio,
            'status'        => $this->status,
            'gateway'       => $this->relationLoaded('gateway') ?
                new ContribuicaoGatewayPagamentoResource($this->gateway) : null,
        ];
    }

}
