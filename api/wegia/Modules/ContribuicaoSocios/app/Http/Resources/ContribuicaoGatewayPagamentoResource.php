<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContribuicaoGatewayPagamentoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'         => $this->id,
            'plataforma' => $this->plataforma,
            'endPoint'   => $this->endPoint,
            'token'      => $this->token,
            'status'     => $this->status,
        ];
    }

}
