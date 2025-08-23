<?php

namespace Modules\Pet\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EspecieResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_pet_especie' => $this->id_pet_especie,
            'descricao'      => $this->descricao
        ];
    }

}
