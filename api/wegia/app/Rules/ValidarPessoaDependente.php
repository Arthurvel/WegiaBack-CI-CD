<?php

namespace App\Rules;

use App\Models\Pessoa\PessoaDependente;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidarPessoaDependente implements ValidationRule
{
    protected $idPessoa;

    public function __construct($idPessoa)
    {
        $this->idPessoa = $idPessoa;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->idPessoa == $value) {
            $fail('A pessoa não pode ser dependente de si mesma.');
        }

        $relacaoExistente = PessoaDependente::where('id_pessoa', $this->idPessoa)
                                             ->where('id_dependente_pessoa', $value)
                                             ->exists();

        if ($relacaoExistente) {
            $fail('Já existe uma relação de dependência entre essas pessoas.');
        }
    }
}
