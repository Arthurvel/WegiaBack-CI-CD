<?php

namespace Modules\Memorando\app\Http\Resources;

use App\Helpers\UploadSeguroHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class AnexoResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id_anexo'    => $this->id_anexo,
            'id_despacho' => $this->id_despacho,
            'anexo'       => UploadSeguroHelper::urlTemporaria($this->anexo),
            'extensao'    => $this->extensao,
            'nome'        => $this->nome,
        ];
    }
}
