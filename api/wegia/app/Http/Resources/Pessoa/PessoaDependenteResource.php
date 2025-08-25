<?php

namespace App\Http\Resources\Pessoa;

use Illuminate\Http\Resources\Json\JsonResource;

class PessoaDependenteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_dependente'        => $this->id_dependente,
            'id_pessoa'            => $this->id_pessoa,
            'id_dependente_pessoa' => $this->id_dependente_pessoa,
            'parentesco'           => $this->parentesco,
            'titular'              => $this->relationLoaded('titular') ? new PessoaResource($this->titular) : null,
            'dependente'           => $this->relationLoaded('dependente') ? new PessoaResource($this->dependente) : null
        ];
    }
}

