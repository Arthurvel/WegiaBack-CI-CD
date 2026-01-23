<?php

namespace app\Http\Resources\Atendido\Aceitacao;

use App\Http\Resources\Pessoa\PessoaResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoAceitacaoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'          => $this->id,
            'data_inicio' => $this->data_inicio ? Carbon::parse($this->data_inicio)->format('d/m/Y') : null,
            'data_fim'    => $this->data_fim ? Carbon::parse($this->data_fim)->format('d/m/Y') : null,
            'descricao'   => $this->descricao,
            'id_status'   => $this->id_status,
            'id_pessoa'   => $this->id_pessoa,

            'pessoa'      => $this->relationLoaded('pessoa')
                ? new PessoaResource($this->pessoa) : null,

            'arquivos'      => $this->relationLoaded('arquivos')
                ? AtendidoAceitacaoArquivoResource::collection($this->arquivos) : null,

            'status'      => $this->relationLoaded('status')
                ? new AtendidoAceitacaoPaStatusResource($this->status) : null,

            'etapas'      => $this->relationLoaded('etapas')
                ? AtendidoAceitacaoPaEtapaResource::collection($this->etapas) : null,
        ];
    }
}
