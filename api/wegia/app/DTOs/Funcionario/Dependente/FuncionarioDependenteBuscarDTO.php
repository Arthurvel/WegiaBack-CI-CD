<?php

namespace app\DTOs\Funcionario\Dependente;

use App\DTOs\BaseDTO;

class FuncionarioDependenteBuscarDTO extends BaseDTO
{

    public ?array $items;
    public ?int $paginaAtual;
    public ?int $totalPaginas;
    public ?int $totalItens;
    public ?int $itensPorPagina;
    public ?int $id_funcionario;

}
