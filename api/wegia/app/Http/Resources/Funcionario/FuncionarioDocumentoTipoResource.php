<?php

namespace app\Http\Resources\Funcionario;

use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioDocumentoTipoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id_docfuncional' => $this->id_docfuncional,
            'nome_docfuncional'     => $this->nome_docfuncional,
        ];
    }

}
