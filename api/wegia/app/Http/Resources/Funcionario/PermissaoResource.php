<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissaoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id_permissao' => $this->id_permissao,
            'nome'         => $this->nome,
        ];
    }

}
