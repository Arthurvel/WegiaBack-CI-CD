<?php

namespace app\DTOs\Funcionario\Remuneracao;

use App\DTOs\BaseDTO;

class FuncionarioRemuneracaoBuscarDTO extends BaseDTO
{

    public int $id_funcionario;
    public ?string $buscar;
    public ?string $ordenacao;
    public ?string $tipoOrdenacao;
    public ?int $itensPorPagina;
    public ?int $pagina;

}
