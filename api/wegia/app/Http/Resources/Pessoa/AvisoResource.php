<?php

namespace app\Http\Resources\Pessoa;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AvisoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_aviso'      => $this->id_aviso,
            'id_pessoa'     => $this->id_pessoa,
            'titulo'        => $this->titulo,
            'descricao'     => $this->descricao,
            'data_criacao'  => $this->data_criacao
                ? Carbon::parse($this->data_criacao)->format('d/m/Y H:i:s')
                : null,
            'nivel'         => $this->nivel,
            'ativo'         => $this->ativo,
        ];
    }

}
