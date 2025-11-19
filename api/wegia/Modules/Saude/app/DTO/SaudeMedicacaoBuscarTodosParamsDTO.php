<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeMedicacaoBuscarTodosParamsDTO extends BaseDTO
{

    public int $id_fichamedica;
    public ?string $buscar;
    public ?string $ordenacao;
    public ?string $tipoOrdenacao;
    public ?string $pagina;
    public ?string $itensPorPagina;
    public ?string $status;

}
