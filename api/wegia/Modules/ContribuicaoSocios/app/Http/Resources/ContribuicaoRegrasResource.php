<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoMeioDePagamento;

class ContribuicaoRegrasResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'    => $this->id,
            'regra' => $this->regra
        ];
    }
}
