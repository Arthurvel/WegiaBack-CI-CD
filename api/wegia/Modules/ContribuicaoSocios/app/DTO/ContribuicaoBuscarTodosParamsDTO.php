<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\PaginacaoFiltrosDTO;

class ContribuicaoBuscarTodosParamsDTO extends PaginacaoFiltrosDTO
{

    public int $periodo;
    public int $id_socio;
    public int $status;

}
