<?php

namespace app\Http\Resources\Configuracao;

use Illuminate\Http\Resources\Json\JsonResource;

class CampoImagemResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_campo'   => $this->id_campo,
            'nome_campo' => $this->nome_campo,
            'tipo'       => $this->tipo,
            'imagens'    => $this->relationLoaded('imagens')
                ? ImagemResource::collection($this->imagens) : null,
        ];
    }

}
