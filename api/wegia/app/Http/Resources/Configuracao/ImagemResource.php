<?php

namespace app\Http\Resources\Configuracao;

use App\Helpers\UploadSeguroHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class ImagemResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_imagem' => $this->id_imagem,
            'nome'      => $this->nome,
            'imagem'    => $this->imagem ? UploadSeguroHelper::urlTemporaria($this->imagem) : null,
            'tipo'      => $this->tipo
        ];
    }

}

