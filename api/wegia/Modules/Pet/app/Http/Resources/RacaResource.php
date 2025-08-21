<?php

namespace Modules\Pet\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RacaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_pet_raca' => $this->id_pet_raca,
            'descricao'      => $this->descricao
        ];
    }

}
