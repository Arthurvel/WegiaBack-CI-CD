<?php

namespace App\Http\Resources\Funcionario;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id_funcionario'                => $this->id_funcionario,
            'id_pessoa'                     => $this->id_pessoa,
            'id_situacao'                   => $this->id_situacao,
            'id_perfil'                     => $this->id_perfil,
            'data_admissao'                 => $this->data_admissao
                ? Carbon::parse($this->data_admissao)->format('d/m/Y')
                : null,
            'pis'                           => $this->pis,
            'ctps'                          => $this->ctps,
            'uf_ctps'                       => $this->uf_ctps,
            'numero_titulo'                 => $this->numero_titulo,
            'zona'                          => $this->zona,
            'secao'                         => $this->secao,
            'certificado_reservista_numero' => $this->certificado_reservista_numero,
            'certificado_reservista_serie'  => $this->certificado_reservista_serie,
            'perfil'                        => $this->relationLoaded('perfil') ?
                new PerfilResource($this->perfil) : null
        ];
    }

}
