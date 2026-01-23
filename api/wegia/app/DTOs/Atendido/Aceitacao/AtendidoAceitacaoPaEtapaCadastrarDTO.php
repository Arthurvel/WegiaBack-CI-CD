<?php

namespace app\DTOs\Atendido\Aceitacao;

use App\DTOs\BaseDTO;

class AtendidoAceitacaoPaEtapaCadastrarDTO extends BaseDTO
{

    public string $data_inicio;
    public string $descricao;
    public int $id_status;
    public int $id_processo;

}
