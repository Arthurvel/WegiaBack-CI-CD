<?php

namespace Modules\ContribuicaoSocios\app\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoMeioDePagamento;

class PagamentoCartaoRule implements Rule
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

        if($meioNome == 'cartaoCredito' & empty($value)){
            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->mensagem ?: 'Adicione a hash do cartão.';
    }

}
