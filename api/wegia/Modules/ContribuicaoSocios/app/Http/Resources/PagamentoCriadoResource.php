<?php

namespace Modules\ContribuicaoSocios\app\Http\Resources;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PagamentoCriadoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'url'               => $this->url,
            'imagem'            => $this->imagem,
            'id_pedido'         => $this->id_pedido,
            'metodo'            => $this->metodo,
            'vencimento'        => $this->vencimento ? Carbon::parse($this->vencimento)->format('d/m/Y') : null,
            'url_privada' => $this->url_privada ? UploadSeguroHelper::urlTemporaria($this->url_privada) : null,
        ];
    }

}
