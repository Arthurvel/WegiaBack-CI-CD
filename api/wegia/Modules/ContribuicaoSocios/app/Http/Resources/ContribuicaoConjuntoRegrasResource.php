<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContribuicaoConjuntoRegrasResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'               => $this->id,
            'id_meioPagamento' => $this->id_meioPagamento,
            'id_regra'         => $this->id_regra,
            'valor'            => $this->valor,
            'status'           => $this->status,
            'meio_pagamento'       => $this->relationLoaded('meioPagamento') ?
                new ContribuicaoMeioPagamentoResource($this->meioPagamento) : null,
            'regra'       => $this->relationLoaded('regra') ?
                new ContribuicaoRegrasResource($this->regra) : null,
        ];
    }
}
