<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContribuicaoMeioPagamentoAtivosResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'            => $this->id,
            'meio'          => $this->meio,
            'regras'        => $this->relationLoaded('regras') ?
                ContribuicaoConjuntoRegrasResource::collection($this->regras) : null,
            'gateway'       => $this->relationLoaded('gateway') ?
                new ContribuicaoGatewayPagamentoResource($this->gateway) : null,

        ];
    }

}

