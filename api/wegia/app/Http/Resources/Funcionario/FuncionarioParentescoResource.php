<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioParentescoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id_parentesco' => $this->id_parentesco,
            'descricao'     => $this->descricao
        ];
    }

}
