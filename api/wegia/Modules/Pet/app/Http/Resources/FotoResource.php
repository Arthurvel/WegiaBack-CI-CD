<?php

namespace Modules\Pet\app\Http\Resources;

use App\Helpers\UploadSeguroHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class FotoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id_pet_foto' => $this->id_pet_foto,
            'arquivo_foto_pet' => UploadSeguroHelper::urlTemporaria($this->arquivo_foto_pet),
            'arquivo_foto_pet_nome' => $this->arquivo_foto_pet_nome,
            'arquivo_foto_pet_extensao' => $this->arquivo_foto_pet_extensao,
        ];
    }
}
