<?php

namespace app\Http\Resources\Atendido;

use App\Http\Resources\Pessoa\PessoaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'idatendido'                        => $this->idatendido,
            'pessoa_id_pessoa'                  => $this->pessoa_id_pessoa,
            'atendido_tipo_idatendido_tipo'     => $this->atendido_tipo_idatendido_tipo,
            'atendido_status_idatendido_status' => $this->atendido_status_idatendido_status,
            'pessoa'                            => $this->relationLoaded('pessoa')
                ? new PessoaResource($this->pessoa) : null,
            'tipo'                      => $this->relationLoaded('atendidoTipo')
                ? new AtendidoTipoResource($this->atendidoTipo) : null,
            'status'                    => $this->relationLoaded('atendidoStatus')
                ? new AtendidoStatusResource($this->atendidoStatus) : null,
        ];
    }

}
