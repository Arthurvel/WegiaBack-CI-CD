<?php

namespace app\DTOs\Configuracao;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class ImagemEmUmCampoAtualizarDTO extends BaseDTO
{

    public ?UploadedFile $imagem = null;
    public int $id_imagem;
    public int $id_campo;
    public ?int $id_imagem_nova = null;

}
