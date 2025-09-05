<?php

namespace app\DTOs\Pessoa\Arquivo;

use App\DTOs\BaseDTO;

class PessoaArquivoCadastrarDTO extends BaseDTO
{

    public string $arquivo;
    public string $nome_arquivo;
    public string $extensao_arquivo;
    public int $id_pessoa_tipo_arquivo;
    public int $id_pessoa;

}
