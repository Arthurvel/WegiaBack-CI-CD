<?php

namespace App\DTOs\Funcionario;

use Carbon\Carbon;

class CadastrarRemuneracaoDTO
{
    public int $funcionario_id_funcionario;
    public int $funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo;
    public float $valor;
    public ?Carbon $inicio;
    public ?Carbon $fim;

    public function __construct(
        int $funcionario_id_funcionario,
        int $funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo,
        float $valor,
        ?Carbon $inicio = null,
        ?Carbon $fim = null
    ) {
        $this->funcionario_id_funcionario   = $funcionario_id_funcionario;
        $this->funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo  = $funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo;
        $this->valor  = $valor;
        $this->inicio = $inicio;
        $this->fim    = $fim;
    }

    public static function fromArray(array $dados): self
    {
        return new self(    
            $dados['funcionario_id_funcionario'],
            $dados['funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo'],
            $dados['valor'],
            isset($dados['inicio']) ? Carbon::parse($dados['inicio']) : null,
            isset($dados['fim']) ? Carbon::parse($dados['fim']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'funcionario_id_funcionario'   => $this->funcionario_id_funcionario,
            'funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo'  => $this->funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo,
            'valor'  => $this->valor,
            'inicio' => $this->inicio ? $this->inicio->toDateString() : null,
            'fim'    => $this->fim ? $this->fim->toDateString() : null,
        ];
    }
}