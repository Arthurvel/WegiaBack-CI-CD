<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use App\Http\Resources\Pessoa\PessoaResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SocioResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_socio'        => $this->id_socio,
            'id_pessoa'       => $this->id_pessoa,
            'id_sociostatus'  => $this->id_sociostatus,
            'id_sociotipo'    => $this->id_sociotipo,
            'id_sociotag'     => $this->id_sociotag,
            'email'           => $this->email,
            'valor_periodo'   => $this->valor_periodo,
            'data_referencia' => $this->data_referencia ?
                Carbon::parse($this->data_referencia)->format('d/m/Y') : '',

            'pessoa'       => $this->relationLoaded('pessoa') ?
                new PessoaResource($this->pessoa) : null,

            'status'       => $this->relationLoaded('socioStatus') ?
                new SocioStatusResource($this->socioStatus) : null,

            'tipo'       => $this->relationLoaded('socioTipo') ?
                new StatusTipoResource($this->socioTipo) : null,

            'tag'       => $this->relationLoaded('socioTag') ?
                new SocioTagResource($this->socioTag) : null
        ];
    }
}
