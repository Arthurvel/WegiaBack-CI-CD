<?php

namespace app\DTOs\Atendido\Aceitacao;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class AtendidoAceitacaoEtapaArquivoCadastrarDTO extends BaseDTO
{

    public int $etapa_id;
    public string $arquivo_nome;
    public string $arquivo_extensao;
    public UploadedFile|string $arquivo;

}
