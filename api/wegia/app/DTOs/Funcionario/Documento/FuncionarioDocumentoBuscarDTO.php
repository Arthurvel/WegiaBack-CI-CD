<?php

namespace app\DTOs\Funcionario\Documento;

use App\DTOs\BaseDTO;

class FuncionarioDocumentoBuscarDTO extends BaseDTO
{

    public int $id_funcionario;
    public array $items;
    public int $paginaAtual;
    public int $totalPaginas;
    public int $totalItens;
    public int $itensPorPagina;

}
