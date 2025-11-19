<?php

namespace App\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class PerfilResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id_perfil'  => $this->id_perfil,
            'nome'       => $this->nome,
            'cargo'      => $this->cargo,
            'permissoes' =>  $this->relationLoaded('permissoes') ? PermissaoResource::collection($this->permissoes) : null,
        ];
    }
}
