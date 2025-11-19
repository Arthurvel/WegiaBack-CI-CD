<?php

namespace Modules\Saude\app\Http\Resources;

use App\Http\Resources\Funcionario\FuncionarioResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeMedicamentoAdministracaoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'idsaude_medicamento_administracao' => $this->idsaude_medicamento_administracao,
            'aplicacao'                         => $this->aplicacao
                ?  Carbon::parse($this->aplicacao)->format('d/m/Y H:i:s') : null,
            'saude_medicacao_id_medicacao'      => $this->saude_medicacao_id_medicacao,
            'funcionario_id_funcionario'        => $this->funcionario_id_funcionario,
            'funcionario'                       => $this->relationLoaded('funcionario')
                ? new FuncionarioResource($this->funcionario) : null

        ];
    }

}
