<?php

namespace Modules\Pet\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdocaoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_adocao'   => $this->id_adocao,
            'id_pet'      => $this->id_pet,
            'id_pessoa'   => $this->id_pessoa,
            'data_adocao' => $this->data_adocao ? Carbon::parse($this->data_adocao)->format('d/m/Y') : null,
            'pessoa'      => $this->relationLoaded('pessoa') ? $this->pessoa : null,
        ];
    }

}
