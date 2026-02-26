<?php

namespace App\Http\Resources\Configuracao;

use Illuminate\Http\Resources\Json\JsonResource;

class SelecaoParagrafoResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id_selecao' => $this->id_selecao,
            'nome_campo' => $this->nome_campo,
            'paragrafo'  => $this->paragrafo,
            'original'   => $this->original,
        ];
    }
}
