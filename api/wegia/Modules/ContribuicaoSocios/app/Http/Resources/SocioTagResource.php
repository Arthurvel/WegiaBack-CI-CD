<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SocioTagResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_sociotag' => $this->id_sociotag,
            'tag'         => $this->tag
        ];
    }
}
