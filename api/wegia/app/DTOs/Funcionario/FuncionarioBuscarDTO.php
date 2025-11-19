<?php

namespace app\DTOs\Funcionario;

use App\DTOs\BaseDTO;

class FuncionarioBuscarDTO extends BaseDTO
{

    public int $id_situacao;
    public string $buscar;
    public string $ordenacao;
    public string $tipoOrdenacao;
    public int $itensPorPagina;
    public int $pagina;

}
