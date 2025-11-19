<?php

namespace app\DTOs\Funcionario;

use App\DTOs\BaseDTO;

class FuncionarioCadastrarDTO extends BaseDTO
{

    public ?int $id_pessoa;
    public int $id_perfil;
    public int $id_situacao;
    public string $data_admissao;
    public ?string $pis;
    public string $ctps = '0';
    public ?string $uf_ctps;
    public ?string $numero_titulo;
    public ?string $zona;
    public ?string $secao;
    public ?string $certificado_reservista_numero;
    public ?string $certificado_reservista_serie;

}
