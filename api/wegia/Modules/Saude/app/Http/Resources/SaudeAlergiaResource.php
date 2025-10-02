<?php

namespace Modules\Saude\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaudeAlergiaResource extends JsonResource
{

    public function toArray($request) {
        return [
            "id_alergia" => $this->id_alergia,
            "nome"       => $this->nome
        ];
    }

}
