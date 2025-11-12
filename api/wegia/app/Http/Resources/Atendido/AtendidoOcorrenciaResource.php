<?php

namespace app\Http\Resources\Atendido;

use App\DTOs\Atendido\AtendidoOcorrenciaDocDTO;
use App\Http\Resources\Funcionario\FuncionarioResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoOcorrenciaResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'idatendido_ocorrencias'                                => $this->idatendido_ocorrencias,
            'atendido_idatendido'                                   => $this->atendido_idatendido,
            'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos' => $this->atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos,
            'funcionario_id_funcionario'                            => $this->funcionario_id_funcionario,
            'data'                                                  => Carbon::parse($this->data)->format('d/m/Y') ?? null,
            'descricao'                                             => $this->descricao,
            'tipo'                                                  => $this->relationLoaded('tipos')
                ? new AtendidoOcorrenciaTipoResource($this->tipos) : null,
            'documento'                                             => $this->relationLoaded('documento')
                ? new AtendidoOcorrenciaDocumentoResource($this->documento) : null,
            'atendido'                                              => $this->relationLoaded('atendido')
                ? new AtendidoResource($this->atendido) : null,
            'funcionario'                                           => $this->relationLoaded('funcionario')
                ? new FuncionarioResource($this->funcionario) : null,
        ];
    }

}
