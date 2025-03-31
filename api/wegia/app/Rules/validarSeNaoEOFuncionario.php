<?php

namespace App\Rules;

use App\Models\Funcionario\Funcionario;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class validarSeNaoEOFuncionario implements ValidationRule
{

    protected $idFuncionario;

    public function __construct($idFuncionario)
    {
        $this->idFuncionario = $idFuncionario;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $funcionario = Funcionario::find($this->idFuncionario);

        if ($funcionario && $funcionario->id_pessoa == $value) {
            $fail('Um funcionário não pode ser dependente de si mesmo.');
        }
    }
}
