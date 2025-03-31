<?php

namespace App\DTOs\Funcionario;

use App\Models\Funcionario\FuncionarioRemuneracaoTipo;
use Carbon\Carbon;

class FuncionarioRemuneracaoDTO
{
    public int $funcionario_id_funcionario;
    public int $idfuncionario_remuneracao;
    public float $valor;
    public ?Carbon $inicio;
    public ?Carbon $fim;
    public FuncionarioRemuneracaoTipoDTO $tipo;

    public function __construct(
        int $funcionario_id_funcionario,
        int $idfuncionario_remuneracao,
        float $valor,
        ?Carbon $inicio = null,
        ?Carbon $fim = null,
        array $tipo
    ) {
        $tipoDTO = FuncionarioRemuneracaoTipoDTO::fromArray($tipo);

        $this->funcionario_id_funcionario = $funcionario_id_funcionario;
        $this->idfuncionario_remuneracao  = $idfuncionario_remuneracao;
        $this->valor                      = $valor;
        $this->inicio                     = $inicio;
        $this->fim                        = $fim;
        $this->tipo                       = $tipoDTO;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['funcionario_id_funcionario'],
            $dados['idfuncionario_remuneracao'],
            $dados['valor'],
            isset($dados['inicio']) ? Carbon::parse($dados['inicio']) : null,
            isset($dados['fim']) ? Carbon::parse($dados['fim']) : null,
            $dados['remuneracao_tipo']
        );
    }

    public function toArray(): array
    {
        return [
            'idfuncionario_remuneracao'  => $this->idfuncionario_remuneracao,
            'funcionario_id_funcionario' => $this->funcionario_id_funcionario,
            'valor'                      => $this->valor,
            'inicio'                     => $this->inicio ? $this->inicio->toDateString() : null,
            'fim'                        => $this->fim ? $this->fim->toDateString() : null,
            'tipo'                       => $this->tipo
        ];
    }
}