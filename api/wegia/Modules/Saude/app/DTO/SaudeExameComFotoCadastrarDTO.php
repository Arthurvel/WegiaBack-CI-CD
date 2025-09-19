<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeExameComFotoCadastrarDTO extends BaseDTO
{

    public int $id_fichamedica;
    public int $id_exame_tipo;
    public string $data;
    public string $arquivo_nome;
    public string $arquivo_extensao;
    public string $arquivo;

}
