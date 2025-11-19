<?php

namespace Modules\Memorando\app\DTO;

use App\DTOs\BaseDTO;

class MemorandoBuscarTodosDTO extends BaseDTO
{
    public ?string $buscar = null;
    public ?string $ordenacao = null;
    public ?string $tipoOrdenacao = null;
    public ?string $status = null;
    public ?bool $destinatario = null;
    public ?bool $remetente = null;
    public ?int $id_pessoa = null;
    public int $pagina = 1;
    public int $itensPorPagina = 10;
}
