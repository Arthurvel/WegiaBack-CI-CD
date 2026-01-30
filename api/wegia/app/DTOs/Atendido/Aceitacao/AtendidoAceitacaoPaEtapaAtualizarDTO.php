<?php

namespace app\DTOs\Atendido\Aceitacao;

use App\DTOs\BaseDTO;

class AtendidoAceitacaoPaEtapaAtualizarDTO extends BaseDTO
{

    public string $data_inicio;
    public string $data_fim;
    public string $descricao;
    public int $id_status;

}
