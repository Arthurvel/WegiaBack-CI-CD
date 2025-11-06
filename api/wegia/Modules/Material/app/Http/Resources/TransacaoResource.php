<?php

namespace Modules\Material\app\Http\Resources;

use App\Http\Resources\Pessoa\PessoaResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TransacaoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_transacao'         => $this->id_transacao,
            'id_produto'           => $this->id_produto,
            'id_tipo_movimentacao' => $this->id_tipo_movimentacao,
            'id_almoxarifado'      => $this->id_almoxarifado,
            'id_responsavel'       => $this->id_responsavel,
            'id_parceiro'          => $this->id_parceiro,
            'data'                 => Carbon::parse($this->data)->format('d/m/Y'),
            'valor_unitario'       => $this->valor_unitario,
            'quantidade'           => $this->quantidade,

            'transacao_produto' => $this->relationLoaded('transacaoProduto')
                ? TransacaoProdutoResource::collection($this->transacaoProduto)
                : null,

            'parceiro' => $this->relationLoaded('parceiro')
                ? new ParceiroResource($this->parceiro)
                : null,

            'tipo_movimentacao' => $this->relationLoaded('tipoMovimentacao')
                ? new TipoMovimentacaoResource($this->tipoMovimentacao)
                : null,

            'almoxarifado' => $this->relationLoaded('almoxarifado')
                ? new AlmoxarifadoResource($this->almoxarifado)
                : null,

            'responsavel' => $this->relationLoaded('responsavel')
                ? new PessoaResource($this->responsavel)
                : null,
        ];
    }
}
