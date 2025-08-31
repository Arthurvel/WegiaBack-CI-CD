<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioListaInfoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'idfuncionario_listainfo' => $this->idfuncionario_listainfo,
            'descricao' => $this->descricao
        ];
    }

}
