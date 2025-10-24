<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnidadeResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_unidade' => $this->id_unidade,
            'descricao'  => $this->descricao
        ];
    }

}

