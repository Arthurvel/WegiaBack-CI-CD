<?php

namespace app\DTOs\Atendido\Aceitacao;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class AtendidoAceitacaoPaArquivoCadastrarDTO extends BaseDTO
{
    public int $id_processo;
    public string $arquivo_nome;
    public string $arquivo_extensao;
    public UploadedFile|string $arquivo;
}
