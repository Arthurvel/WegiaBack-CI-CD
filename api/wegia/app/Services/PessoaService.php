<?php

namespace App\Services;

use App\DTOs\Pessoa\PessoaAtualizarDTO;
use App\DTOs\Pessoa\PessoaDTO;
use App\Repositories\PessoaRepository;
use App\Models\Pessoa;

class PessoaService
{
    private $pessoaRepository;

    public function __construct(PessoaRepository $pessoaRepository)
    {
        $this->pessoaRepository = $pessoaRepository;
    }

    public function cadastrarPessoa(array $pessoa) : Pessoa
    {
        return $this->pessoaRepository->cadastrarPessoa($pessoa);
    }

    public function buscarPessoaPorCpf(string $cpf) : Pessoa
    {
        return $this->pessoaRepository->buscarPessoaPorCpf($cpf);
    }

    public function atualizarPessoa(array $pessoa, int $id) : array
    {
        $pessoaAtualizaDTO = PessoaAtualizarDTO::fromArray($pessoa);

        $pessoaAtualizada = $this->pessoaRepository->atualizarPessoa($pessoaAtualizaDTO, $id);
    
        return PessoaDTO::fromArray($pessoaAtualizada->toArray())->toArray();
    }
}