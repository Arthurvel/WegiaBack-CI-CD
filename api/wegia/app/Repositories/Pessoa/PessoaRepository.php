<?php

namespace app\Repositories\Pessoa;

use App\DTOs\Pessoa\CadastrarPessoaDependenteDTO;
use App\DTOs\Pessoa\PessoaAtualizarDTO;
use App\DTOs\Pessoa\PessoaAtualizarSenhaDTO;
use App\Models\Pessoa\Pessoa;
use App\Models\Pessoa\PessoaDependente;
use App\Repositories\Base\BaseRepository;

class PessoaRepository extends BaseRepository
{

    public function __construct(
        Pessoa $model
    )
    {
        parent::__construct($model);
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
        return $this->model->where('cpf', $cpf)->firstOrFail();
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

    public function criarParentesco(CadastrarPessoaDependenteDTO $dependente) : PessoaDependente
    {
        return PessoaDependente::create($dependente->toArray());
    }

    public function deletarDependente(int $id_dependente) : bool
    {
        return PessoaDependente::destroy($id_dependente);
    }

}
