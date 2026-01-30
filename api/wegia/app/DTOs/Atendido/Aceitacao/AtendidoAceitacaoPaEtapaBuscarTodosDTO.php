<?php

namespace app\DTOs\Atendido\Aceitacao;

use App\DTOs\BaseDTO;

class AtendidoAceitacaoPaEtapaBuscarTodosDTO extends BaseDTO
{
    public int $id_processo;
    public string $status;
    public string $paginacao;
    public string $itensPorPagina;
}
