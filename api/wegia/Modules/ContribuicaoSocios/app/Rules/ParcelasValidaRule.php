<?php

namespace Modules\ContribuicaoSocios\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoMeioDePagamento;

class ParcelasValidaRule  implements Rule
{
    private ContribuicaoMeioDePagamento $meio;
    private $mensagem;

    public function __construct(ContribuicaoMeioDePagamento $meio)
    {
        $this->meio = $meio;
    }

    public function passes($attribute, $value)
    {
        $meioNome = strtolower($this->meio->meio);

        $regras = [
            'carne' => ['min' => 2, 'max' => 12],
        ];

        if (!array_key_exists($meioNome, $regras)) {
            return true;
        }

        $min = $regras[$meioNome]['min'];
        $max = $regras[$meioNome]['max'];

        if ($value < $min || $value > $max) {
            $this->mensagem = "O número de parcelas deve estar entre $min e $max.";
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->mensagem;
    }
}
