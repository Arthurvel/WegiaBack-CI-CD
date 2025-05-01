<?php

namespace App\Services;

use App\DTOs\PaginacaoDTO;
use App\DTOs\Pessoa\CadastrarPessoaDependenteDTO;
use App\DTOs\Pessoa\PessoaAtualizarDTO;
use App\DTOs\Pessoa\PessoaDependenteDTO;
use App\DTOs\Pessoa\PessoaDTO;
use App\Helpers\UploadSeguroHelper;
use App\Repositories\PessoaRepository;
use App\Models\Pessoa;
use App\Models\Pessoa\PessoaDependente;

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
            $url = UploadSeguroHelper::salvarImagem($pessoa['imagem'], 'pessoa');
            $pessoa['imagem'] = $url;
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

    public function cadastrarOuAtualizarImagem(array $dados, String $id_pessoa)
    {
        $url = UploadSeguroHelper::salvarImagem($dados['imagem'], 'pessoa');

        $pessoaAtualizada = $this->pessoaRepository->cadastrarOuAtualizarImagem($url, $id_pessoa);

        return $pessoaAtualizada;
    }

    public function buscarDependentesPorIdPessoa(int $id_pessoa, array $filtros = []) : PaginacaoDTO
    {
        $dependentes = $this->pessoaRepository->buscarDependentesPorIdPessoa($id_pessoa, $filtros);

        $itens = collect($dependentes->items())->map(function ($dependente) {
            return PessoaDependenteDTO::fromArray($dependente->toArray());
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $dependentes->currentPage(),
            $dependentes->lastPage(),
            $dependentes->total(),
            $dependentes->perPage()
        ); 
    }

    public function criarParentesco(array $dados, String $id_pessoa, int $id_dependente) : PessoaDependente
    {
        $array = [
            'id_pessoa' => $id_pessoa,
            'id_dependente_pessoa' => $id_dependente,
            'parentesco' => $dados['parentesco']
        ];
        $dependenteDTO = CadastrarPessoaDependenteDTO::fromArray($array);

        return $this->pessoaRepository->criarParentesco($dependenteDTO);
    }

    public function deletarDependente(int $id_dependente) : bool
    {
        return $this->pessoaRepository->deletarDependente($id_dependente);
    }
}