<?php

namespace Modules\ContribuicaoSocios\app\DTO;

use App\DTOs\BaseDTO;

class PagamentoCadastrarDTO extends BaseDTO
{

    public int $id_socio;
    public int $id_contribuicao_meioPagamento;
    public int $data_vencimento;
    public float $valor;
    public int $parcelas;
    public ?string $cartao_hash;

}
