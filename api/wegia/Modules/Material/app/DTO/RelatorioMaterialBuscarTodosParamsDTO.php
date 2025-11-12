<?php

namespace Modules\Material\app\DTO;

use App\DTOs\BaseDTO;

class RelatorioMaterialBuscarTodosParamsDTO extends BaseDTO
{

    public ?string $periodo_inicial = null;
    public ?string $periodo_final = null;
    public ?int $id_tipo_movimentacao = null;
    public ?string $tipo_movimentacao = null;
    public ?int $id_parceiro = null;
    public ?int $id_responsavel = null;
    public ?int $id_almoxarifado = null;

}
