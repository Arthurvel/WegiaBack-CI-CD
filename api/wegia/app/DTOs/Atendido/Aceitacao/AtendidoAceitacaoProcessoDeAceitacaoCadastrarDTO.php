<?php

namespace app\DTOs\Atendido\Aceitacao;

use App\DTOs\BaseDTO;

class AtendidoAceitacaoProcessoDeAceitacaoCadastrarDTO extends BaseDTO
{
    public string $data_inicio;
    public ?string $data_fim = null;
    public string $descricao = 'Processo de aceitação inicial';
    public int $id_status = 1;
    public int $id_pessoa;
}
