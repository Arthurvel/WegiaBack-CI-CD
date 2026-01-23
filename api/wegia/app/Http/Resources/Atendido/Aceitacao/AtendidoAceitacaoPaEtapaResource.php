<?php

namespace app\Http\Resources\Atendido\Aceitacao;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoAceitacaoPaEtapaResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'          => $this->id,
            'data_inicio' => $this->data_inicio ? Carbon::parse($this->data_inicio)->format('d/m/Y') : null,
            'data_fim'    => $this->data_fim ? Carbon::parse($this->data_fim)->format('d/m/Y') : null,
            'descricao'   => $this->descricao,
            'id_status'   => $this->id_status,
            'id_processo' => $this->id_processo,

            'status'      => $this->relationLoaded('status')
                ? new AtendidoAceitacaoPaStatusResource($this->status) : null,

            'arquivos'      => $this->relationLoaded('arquivos')
                ? AtendidoAceitacaoEtapaArquivoResource::collection($this->arquivos) : null
        ];
    }
}
