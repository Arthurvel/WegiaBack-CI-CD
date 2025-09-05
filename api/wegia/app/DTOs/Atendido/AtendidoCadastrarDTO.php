<?php

namespace app\DTOs\Atendido;

use App\DTOs\BaseDTO;

class AtendidoCadastrarDTO extends BaseDTO
{

    public string $pessoa_id_pessoa;
    public string $atendido_tipo_idatendido_tipo;
    public string $atendido_status_idatendido_status;

}
