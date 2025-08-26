<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioInfoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'idfunncionario_outrasinfo' => $this->idfunncionario_outrasinfo,
            'id_funcionario'            => $this->funcionario_id_funcionario,
            'dado'                      => $this->dado,
            'lista_info'                => $this->relationLoaded('listaInfo') ? $this->listaInfo->descricao : null
        ];
    }

}
