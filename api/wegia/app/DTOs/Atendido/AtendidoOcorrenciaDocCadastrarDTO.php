<?php

namespace App\DTOs\Atendido;

use App\DTOs\BaseDTO;
use Carbon\Carbon;

class AtendidoOcorrenciaDocCadastrarDTO extends BaseDTO
{
    public int $atentido_ocorrencia_idatentido_ocorrencias;
    public string $data;
    public string $arquivo_nome;
    public string $arquivo_extensao;
    public string $arquivo;

}
