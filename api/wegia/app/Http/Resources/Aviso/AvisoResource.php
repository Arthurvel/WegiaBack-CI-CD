<?php

namespace App\Http\Resources\Aviso;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Memorando\app\Http\Resources\DespachoResource;

class AvisoResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id_aviso'          => $this->id_aviso,
            'id_pessoa'         => $this->id_pessoa,
            'titulo'            => $this->titulo,
            'descricao'         => $this->descricao,
            'data_criacao'      => Carbon::parse($this->data_criacao)->format('d/m/Y'),
            'url'               => $this->url,
            'nivel'             => $this->nivel,
            'ativo'             => $this->ativo
        ];
    }
}
