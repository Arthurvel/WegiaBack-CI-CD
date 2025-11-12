<?php

namespace Modules\Saude\app\Http\Resources;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaudeExameResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id_exame'         => $this->id_exame,
            'id_fichamedica'   => $this->id_fichamedica,
            'id_exame_tipo'    => $this->id_exame_tipo,
            'data'             => $this->data ?
                Carbon::parse($this->data)->format('d/m/Y') : null,
            'arquivo_nome'     => $this->arquivo_nome,
            'arquivo_extensao' => $this->arquivo_extensao,
            'arquivo'          => $this->arquivo ? UploadSeguroHelper::urlTemporaria($this->arquivo) : null,
            'tipo'             => $this->relationLoaded('tipo') ? new SaudeExameTipoResource($this->tipo) : null
        ];
    }

}
