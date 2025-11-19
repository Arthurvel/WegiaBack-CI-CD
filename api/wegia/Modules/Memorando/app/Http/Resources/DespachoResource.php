<?php

namespace Modules\Memorando\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DespachoResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id_despacho'      => $this->id_despacho,
            'id_memorando'     => $this->id_memorando,
            'id_remetente'     => $this->id_remetente,
            'id_destinatario'  => $this->id_destinatario,
            'texto'            => $this->texto,
            'data'             => Carbon::parse($this->data)->format('d/m/Y H:i:s'),
            'anexos'           => $this->anexos ? AnexoResource::collection($this->anexos) : null,
            'remetente'        => $this->remetente ? $this->remetente->nome : null,
            'destinatario'     => $this->destinatario ? $this->destinatario->nome : null,

        ];
    }
}
