<?php

namespace App\Repositories;

use App\DTOs\Pessoa\CadastrarPessoaDependenteDTO;
use App\DTOs\Pessoa\PessoaAtualizarDTO;
use App\DTOs\Pessoa\PessoaAtualizarSenhaDTO;
use App\Models\Pessoa;
use App\Models\Pessoa\PessoaDependente;

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

    public function buscarPessoaParaFiltros()
    {
        return Pessoa::select(['id_pessoa', 'nome'])
            ->get();
    }


    public function atualizarPessoa(PessoaAtualizarDTO $pessoa, int $id) : Pessoa
    {
        $pessoaEncontrada = $this->buscarPessoaPorId($id);

        $pessoaEncontrada->update($pessoa->toArray());

        return $pessoaEncontrada;
    }

    public function mudarSenha(PessoaAtualizarSenhaDTO $dto)
    {
        $pessoa = $this->buscarPessoaPorId($dto->id_pessoa);

        return $pessoa->update(["senha" => $dto->senha] );
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

    public function buscarDependentesPorIdPessoa(int $id_pessoa, array $parametros)
    {
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;
        $with           = isset($parametros['with']) ? explode(',', $parametros['with']) : [];

        return PessoaDependente::with($with)
            ->where('pessoa_dependente.id_pessoa', $id_pessoa)
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('dependente', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%");
                })->orWhere('parentesco', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'nome') {
                    return $q->join('pessoa', 'pessoa_dependente.id_dependente_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy("pessoa.{$ordenacao}", $tipoOrdenacao);
                }

                return $q->orderBy("pessoa_dependente.{$ordenacao}", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }


    public function criarParentesco(CadastrarPessoaDependenteDTO $dependente) : PessoaDependente
    {
        return PessoaDependente::create($dependente->toArray());
    }

    public function deletarDependente(int $id_dependente) : bool
    {
        return PessoaDependente::destroy($id_dependente);
    }

}
