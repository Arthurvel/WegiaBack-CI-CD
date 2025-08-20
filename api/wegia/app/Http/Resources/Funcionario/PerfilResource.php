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
            'permissoes' => $this->permissoes ? $this->permissoes->map(function ($permissao) {
                return [
                    'id_permissao' => $permissao->id_permissao,
                    'nome'         => $permissao->nome,
                ];
            }) : null,
        ];
    }
}
