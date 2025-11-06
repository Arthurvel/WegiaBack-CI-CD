<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlmoxarifadoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_almoxarifado'        => $this->id_almoxarifado,
            'descricao' => $this->descricao
        ];
    }

}
