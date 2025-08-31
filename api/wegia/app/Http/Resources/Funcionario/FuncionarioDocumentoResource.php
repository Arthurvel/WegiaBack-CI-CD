<?php

namespace app\Http\Resources\Funcionario;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FuncionarioDocumentoResource extends JsonResource
{

    public function toArray($request) {
        return [
            'id_fundocs'             => $this->id_fundocs,
            'id_funcionario'         => $this->id_funcionario,
            'id_docfuncional'        => $this->id_docfuncional,
            'nome_arquivo'           => $this->nome_arquivo,
            'extensao_arquivo'       => $this->extensao_arquivo,
            'nome_docfuncional'      => $this->relationLoaded('funcionarioDocFuncional') ?  $this->funcionarioDocFuncional->nome_docfuncional : null,
            'descricao_docfuncional' => $this->relationLoaded('funcionarioDocFuncional') ?  $this->funcionarioDocFuncional->descricao_docfuncional : null,
            'data'                   => $this->data ? Carbon::parse($this->data)->format('d/m/Y') : null,
            'arquivo'                => $this->arquivo ? UploadSeguroHelper::urlTemporaria($this->arquivo) : null
        ];
    }

}
