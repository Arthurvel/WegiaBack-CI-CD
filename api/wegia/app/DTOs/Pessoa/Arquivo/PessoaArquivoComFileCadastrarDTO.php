<?php

namespace app\DTOs\Pessoa\Arquivo;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class PessoaArquivoComFileCadastrarDTO extends BaseDto
{

    public UploadedFile $arquivo;
    public int $id_pessoa_tipo_arquivo;
    public int $id_pessoa;

}
