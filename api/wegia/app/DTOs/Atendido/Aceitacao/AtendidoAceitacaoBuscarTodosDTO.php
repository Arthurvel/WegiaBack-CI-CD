<?php

namespace app\DTOs\Atendido\Aceitacao;

use App\DTOs\BaseDTO;

class AtendidoAceitacaoBuscarTodosDTO extends BaseDTO
{
    public string $buscar;
    public string $status;
    public string $paginacao;
    public string $itensPorPagina;
}
