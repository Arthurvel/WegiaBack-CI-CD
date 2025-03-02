<?php

namespace App\Repositories;

use App\Models\Pessoa;

class PessoaRepository
{

    public function cadastrarPessoa(array $pessoa) : Pessoa
    {
        return Pessoa::create($pessoa);
    }

    public function buscarPessoaPorCpf(string $cpf) : Pessoa
    {
        return Pessoa::where('cpf', $cpf)->first();
    }

}