<?php

namespace app\Http\Resources\Pessoa;

use App\Helpers\UploadSeguroHelper;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PessoaArquivoResource extends JsonResource
{

    public function toArray($request) : array
    {
        return [
            'id_pessoa_arquivo'      => $this->id_pessoa_arquivo,
            'id_pessoa'              => $this->id_pessoa,
            'id_pessoa_tipo_arquivo' => $this->id_pessoa_tipo_arquivo,
            'data'                   => $this->data ? Carbon::parse($this->data)->format('d/m/Y') : null,
            'extensao_arquivo'       => $this->extensao_arquivo,
            'nome_arquivo'           => $this->nome_arquivo,
            'arquivo'                => UploadSeguroHelper::urlTemporaria($this->arquivo),
            'tipo'                   => $this->relationLoaded('tipoArquivo')
                ? new PessoaTipoArquivoResource($this->tipoArquivo) : null
        ];
    }

}
