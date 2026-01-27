<?php

namespace app\DTOs\Atendido;

use App\DTOs\BaseDTO;

class AtendidoBuscarDTO extends BaseDTO
{

    public ?string $id_status;
    public ?string $buscar;
    public ?int $itensPorPagina;
    public ?int $pagina;
    public ?string $ordenacao;
    public ?string $tipoOrdenacao;
    public ?string $with;

}
