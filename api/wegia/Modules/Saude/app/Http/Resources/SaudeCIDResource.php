<?php

namespace Modules\Saude\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaudeCIDResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_CID'    => $this->id_CID,
            'CID'       => $this->CID,
            'descricao' => $this->descricao
        ];
    }
}
