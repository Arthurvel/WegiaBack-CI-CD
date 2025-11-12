<?php

namespace app\DTOs\Atendido;

use App\DTOs\BaseDTO;

class AtendidoOcorrenciaBuscarDTO extends BaseDTO
{
    public int $id_atendido;
    public ?int $id_tipo;
    public ?string $buscar;
    public ?int $itensPorPagina;
    public ?int $pagina;
    public ?string $ordenacao;
    public ?string $tipoOrdenacao;
    public ?string $with;

}
