<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContribuicaoLogResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'                => $this->id,
            'id_socio'          => $this->id_socio,
            'id_meio_pagamento' => $this->id_meio_pagamento,
            'codigo'            => $this->codigo,
            'valor'             => $this->valor,
            'data_geracao'      => $this->data_geracao ? Carbon::parse($this->data_geracao)->format('d/m/Y') : null,
            'data_vencimento'   => $this->data_vencimento ? Carbon::parse($this->data_vencimento)->format('d/m/Y') : null,
            'data_pagamento'    => $this->data_pagamento ? Carbon::parse($this->data_pagamento)->format('d/m/Y') : null,
            'status_pagamento'  => $this->status_pagamento,
            'url'               => $this->url ? UploadSeguroHelper::urlTemporaria($this->url) : null,

            'socio'             => $this->relationLoaded('socio') ?
                new SocioResource($this->socio) : null,

            'gateway'           => $this->relationLoaded('gateway') ?
                new ContribuicaoGatewayPagamentoResource($this->gateway) : null,

            'meio_pagamento'           => $this->relationLoaded('meioPagamento') ?
                new ContribuicaoMeioPagamentoResource($this->meioPagamento) : null,
        ];
    }

}
