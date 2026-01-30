<?php

namespace app\Services\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoBuscarTodosDTO;
use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacaoCadastrarDTO;
use app\DTOs\Pessoa\PessoaCadastrarDTO;
use app\Repositories\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacaoRepository;
use app\Repositories\Atendido\AtendidoRepository;
use app\Repositories\Pessoa\PessoaRepository;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class AtendidoAceitacaoProcessoDeAceitacaoService extends BaseService
{

    private PessoaRepository $pessoaRepository;
    private AtendidoRepository $atendidoRepository;

    public function __construct(
        AtendidoAceitacaoProcessoDeAceitacaoRepository $repository,
        PessoaRepository $pessoaRepository,
        AtendidoRepository $atendidoRepository
    )
    {
        parent::__construct($repository);

        $this->pessoaRepository   = $pessoaRepository;
        $this->atendidoRepository = $atendidoRepository;
    }

    public function buscarTodosPaginado(AtendidoAceitacaoBuscarTodosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

    public function criarAceitacaoComPessoa(AtendidoAceitacaoProcessoDeAceitacaoCadastrarDTO $atendidoAceitacaoDTO)
    {
        $atendidoExiste  = $this->atendidoRepository->buscarPorIdPessoa($atendidoAceitacaoDTO->id_pessoa);
        $aceitacaoExiste = $this->repository->buscarPorIdPessoa($atendidoAceitacaoDTO->id_pessoa);

        if ($atendidoExiste) {
            throw new \DomainException('Já existe um atendido cadastrado com este CPF.');
        }

        if ($aceitacaoExiste) {
            throw new \DomainException('Já existe essa pessoa tentando ser aceitada.');
        }

        return $this->repository->criar($atendidoAceitacaoDTO);
    }

    public function criarAceitacao(PessoaCadastrarDTO $pessoaCadastrarDTO)
    {
        $atendidoExiste = $this->atendidoRepository->buscarAtendidoPorCPF($pessoaCadastrarDTO->cpf);

        if ($atendidoExiste) {
            throw new \DomainException('Já existe um atendido cadastrado com este CPF.');
        }

        return DB::transaction(function () use ($pessoaCadastrarDTO) {

            $pessoa = $this->pessoaRepository->criar($pessoaCadastrarDTO);

            $atendidoAceitacaoDTO = AtendidoAceitacaoProcessoDeAceitacaoCadastrarDTO::fromArray([
               'data_inicio' => now()->format('Y-m-d'),
               'id_pessoa'   => $pessoa->id_pessoa
            ]);

            return $this->repository->criar($atendidoAceitacaoDTO);
        });
    }

}
