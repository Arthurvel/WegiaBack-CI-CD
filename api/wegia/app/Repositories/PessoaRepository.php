<?php

namespace App\Repositories;

use App\DTOs\Pessoa\PessoaAtualizarDTO;
use App\Models\Pessoa;

class PessoaRepository
{

    public function cadastrarPessoa(array $pessoa) : Pessoa
    {
        return Pessoa::create($pessoa);
    }
    
    public function cadastrarOuAtualizarPessoa(array $dados): Pessoa
    {
        return Pessoa::updateOrCreate(
            ['cpf' => $dados['cpf']],
            $dados
        );
    
    }

    public function buscarPessoaPorCpf(string $cpf) : Pessoa
    {
        return Pessoa::where('cpf', $cpf)->firstOrFail();
    }

    public function atualizarPessoa(PessoaAtualizarDTO $pessoa, int $id) : Pessoa
    {
        $pessoaEncontrada = $this->buscarPessoaPorId($id);

        $pessoaEncontrada->update($pessoa->toArray());

        return $pessoaEncontrada;
    }

    public function buscarPessoaPorId(int $id): Pessoa
    {
        return Pessoa::findOrFail($id);
    }

    public function cadastrarOuAtualizarImagem(string $arquivo, int $id_pessoa) : Pessoa
    {
        $pessoaEncontrada = $this->buscarPessoaPorId($id_pessoa);

        $pessoaEncontrada->update([
            "imagem" => $arquivo
        ]);

        return $pessoaEncontrada;
    }

}