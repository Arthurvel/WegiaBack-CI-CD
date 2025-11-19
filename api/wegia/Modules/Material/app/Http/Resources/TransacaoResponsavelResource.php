<?php

namespace Modules\Material\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransacaoResponsavelResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_pessoa' => $this->id_pessoa,
            'nome'  => $this->nome
        ];
    }

}
