<?php

namespace App\Services;

use App\DTOs\Pessoa\PessoaAtualizarDTO;
use App\DTOs\Pessoa\PessoaDTO;
use App\Helpers\ArquivoHelper;
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
        if(!empty($pessoa['imagem'])) {
            $pessoa['imagem'] = ArquivoHelper::passarParaBase64($pessoa['imagem']);
        }

        return $this->pessoaRepository->cadastrarPessoa($pessoa);
    }

    public function buscarPessoaPorCpf(string $cpf) : PessoaDTO
    {
        $pessoa = $this->pessoaRepository->buscarPessoaPorCpf($cpf);

        return PessoaDTO::fromArray($pessoa->toArray());
    }

    public function buscarPessoaPorCpfSemFormatacao(string $cpf) : Pessoa
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