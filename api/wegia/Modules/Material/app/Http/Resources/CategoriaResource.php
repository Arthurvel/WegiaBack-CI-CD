<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriaResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_categoria' => $this->id_categoria,
            'descricao'    => $this->descricao
        ];
    }

}
