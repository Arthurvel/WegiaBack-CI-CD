<?php

namespace Modules\Saude\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaudeExameTipoResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id_exame_tipo' => $this->id_exame_tipo,
            'descricao'     => $this->descricao
        ];
    }

}
