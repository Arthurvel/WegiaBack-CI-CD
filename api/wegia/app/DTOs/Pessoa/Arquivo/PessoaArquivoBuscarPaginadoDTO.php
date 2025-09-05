<?php

namespace app\DTOs\Pessoa\Arquivo;

use App\DTOs\BaseDTO;

class PessoaArquivoBuscarPaginadoDTO extends BaseDTO
{

    public int $id_pessoa;
    public string $buscar;
    public string $ordenacao;
    public string $tipoOrdenacao;
    public int $pagina;
    public int $itensPorPagina;

}

