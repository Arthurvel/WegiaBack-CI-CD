<?php

namespace app\Http\Resources\Atendido;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoOcorrenciaDocumentoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'idatendido_ocorrencia_doc'                  => $this->idatendido_ocorrencia_doc,
            'atentido_ocorrencia_idatentido_ocorrencias' => $this->atentido_ocorrencia_idatentido_ocorrencias,
            'data'                                       => Carbon::parse($this->data)->format('d/m/Y') ?? null,
            'arquivo_nome'                               => $this->arquivo_nome,
            'arquivo_extensao'                           => $this->arquivo_extensao,
            'arquivo'                                    => UploadSeguroHelper::urlTemporaria($this->arquivo) ?? null
        ];
    }

}
