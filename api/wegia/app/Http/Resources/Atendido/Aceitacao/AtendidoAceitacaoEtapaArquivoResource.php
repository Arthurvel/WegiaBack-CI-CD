<?php

namespace app\Http\Resources\Atendido\Aceitacao;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AtendidoAceitacaoEtapaArquivoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'               => $this->id,
            'id_etapa'         => $this->etapa_id,
            'arquivo_nome'     => $this->arquivo_nome,
            'arquivo_extensao' => $this->arquivo_extensao,
            'arquivo'          => $this->arquivo ? UploadSeguroHelper::urlTemporaria($this->arquivo) : null,
            'data_upload'      => $this->data_upload ? Carbon::parse($this->data_upload)->format('d/m/Y') : null
        ];
    }

}
