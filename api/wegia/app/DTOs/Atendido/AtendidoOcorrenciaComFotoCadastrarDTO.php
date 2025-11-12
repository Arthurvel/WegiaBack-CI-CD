<?php

namespace app\DTOs\Atendido;

use App\DTOs\BaseDTO;
use Illuminate\Http\UploadedFile;

class AtendidoOcorrenciaComFotoCadastrarDTO extends BaseDTO
{

    public ?UploadedFile $arquivo;
    public int $atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos;
    public int $funcionario_id_funcionario;
    public int $atendido_idatendido;
    public string $data;
    public string $descricao;

}
