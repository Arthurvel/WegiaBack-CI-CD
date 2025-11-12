<?php

namespace app\Http\Resources\Pessoa;

use Illuminate\Http\Resources\Json\JsonResource;

class PessoaTipoArquivoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_pessoa_tipo_arquivo' => $this->id_pessoa_tipo_arquivo,
            'descricao'              => $this->descricao,
        ];
    }

}
