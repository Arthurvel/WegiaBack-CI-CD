<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContribuicaoLogComDocumentoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id'              => $this->id,
            'data_geracao'    => $this->data_geracao ? Carbon::parse($this->data_geracao)->format('d/m/Y') : null,
            'data_vencimento' => $this->data_vencimento ? Carbon::parse($this->data_vencimento)->format('d/m/Y') : null,
            'url'             => $this->url ? UploadSeguroHelper::urlTemporaria($this->url) : null,
        ];
    }

}
