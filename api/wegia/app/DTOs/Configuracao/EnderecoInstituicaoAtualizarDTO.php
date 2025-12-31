<?php

namespace app\DTOs\Configuracao;

use App\DTOs\BaseDTO;

class EnderecoInstituicaoAtualizarDTO extends BaseDTO
{

    public string $nome;
    public string $numero_endereco;
    public string $logradouro;
    public string $bairro;
    public string $cidade;
    public string $estado;
    public string $cep;
    public string $complemento;
    public string $ibge;

}
