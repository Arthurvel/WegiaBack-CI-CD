<?php

namespace Modules\Saude\app\DTO;

use App\DTOs\BaseDTO;

class SaudeAtendimentoComMedicacaoCadastrarDTO extends BaseDTO
{

    public int $id_fichamedica;
    public int $id_funcionario;
    public int $id_medico;
    public ?string $data_atendimento = null;
    public ?string $descricao = null;
    public array $medicacoes = [];

}
