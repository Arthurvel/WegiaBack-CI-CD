<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeMedicacaoAdministracaoBuscarTodosParamDTO extends BaseDTO
{

    public int $id_medicacao;
    public ?int $pagina;
    public ?int $itensPorPagina;

}
