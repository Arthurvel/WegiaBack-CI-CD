<?php

namespace Modules\Memorando\app\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class MemorandoResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            'id_memorando'      => $this->id_memorando,
            'id_pessoa'         => $this->id_pessoa,
            'titulo'            => $this->titulo,
            'data'              => Carbon::parse($this->data)->format('d/m/Y H:i:s'),
            'status_memorando'  => $this->status_memorando,
            'despachos'         => $this->despachos ? DespachoResource::collection($this->despachos) : null
        ];
    }
}
