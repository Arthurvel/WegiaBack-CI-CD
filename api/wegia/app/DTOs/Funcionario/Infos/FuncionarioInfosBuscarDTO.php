<?php

namespace app\DTOs\Funcionario\Infos;

use App\DTOs\BaseDTO;

class FuncionarioInfosBuscarDTO extends BaseDTO
{

    public ?int $id_funcionario;
    public ?array $items;
    public ?int $paginaAtual;
    public ?int $totalPaginas;
    public ?int $totalItens;
    public ?int $itensPorPagina;

}
