<?php

namespace app\DTOs\Configuracao;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class ImagemEmUmCampoCadastrarDTO extends BaseDTO
{

    public ?UploadedFile $imagem;
    public ?string $id_imagem;
    public string $id_campo;

}
