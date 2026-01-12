<?php

namespace app\DTOs\Configuracao;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class ImagemCadastrarDTO extends BaseDTO
{

    public UploadedFile | string $imagem;
    public string $nome;
    public string $tipo;

}
