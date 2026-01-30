<?php

namespace Modules\ContribuicaoSocios\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoConjuntoRegras;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoMeioDePagamento;

class ValorRegraValidaRule implements Rule
{
    private ?ContribuicaoMeioDePagamento $meio;
    private $msg = 'Valor inválido.';

    public function __construct(ContribuicaoMeioDePagamento $meio)
    {
        $this->meio = $meio;
    }

    public function passes($attribute, $value)
    {
        if (!$this->meio) {
            return false;
        }

        $value = (float) $value;

        $regras = ContribuicaoConjuntoRegras::join('contribuicao_regras AS r', 'r.id', '=', 'contribuicao_conjuntoRegras.id_regra')
            ->where('contribuicao_conjuntoRegras.id_meioPagamento', $this->meio->id)
            ->where('contribuicao_conjuntoRegras.status', true)
            ->pluck('contribuicao_conjuntoRegras.valor', 'r.regra')
            ->toArray();

        if (isset($regras['MIN_VALUE']) && $value < $regras['MIN_VALUE']) {
            $this->msg = "O valor deve ser maior ou igual a {$regras['MIN_VALUE']}.";
            return false;
        }

        if (isset($regras['MAX_VALUE']) && $value > $regras['MAX_VALUE']) {
            $this->msg = "O valor deve ser menor ou igual a {$regras['MAX_VALUE']}.";
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->msg;
    }
}
