<?php

namespace Modules\ContribuicaoSocios\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoMeioDePagamento;

class DataVencimentoRule implements Rule
{
    private ContribuicaoMeioDePagamento $meio;
    private string $mensagem = '';

    public function __construct(ContribuicaoMeioDePagamento $meio)
    {
        $this->meio = $meio;
    }

    public function passes($attribute, $value)
    {
        $meioNome = strtolower($this->meio->meio);

        $regras = [
            'carne' => [1, 5, 10, 15, 20, 25],
        ];

        if (!array_key_exists($meioNome, $regras)) {
            return true;
        }

        $dia = (int) $value;

        $diasPermitidos = $regras[$meioNome];

        if (!in_array($dia, $diasPermitidos)) {
            $this->mensagem =
                "A data de vencimento deve cair nos dias: "
                . implode(', ', $diasPermitidos) . ".";
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->mensagem ?: 'Data de vencimento inválida.';
    }
}
