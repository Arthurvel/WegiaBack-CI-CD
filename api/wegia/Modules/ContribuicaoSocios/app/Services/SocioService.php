<?php

namespace Modules\ContribuicaoSocios\app\Services;

use App\DTOs\PaginacaoFiltrosDTO;
use App\DTOs\Pessoa\PessoaAtualizarDTO;
use app\DTOs\Pessoa\PessoaCadastrarDTO;
use app\Repositories\Pessoa\PessoaRepository;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\ContribuicaoSocios\app\DTO\SocioAtualizarDTO;
use Modules\ContribuicaoSocios\app\DTO\SocioCadastrarDTO;
use Modules\ContribuicaoSocios\app\Repositories\SocioRepository;

class SocioService extends BaseService
{

    protected PessoaRepository $pessoaRepository;

    public function __construct
    (
        SocioRepository $repository,
        PessoaRepository $pessoaRepository
    )
    {
        parent::__construct($repository);

        $this->pessoaRepository = $pessoaRepository;
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

    public function buscarTodosAniversariantesMesPaginado(PaginacaoFiltrosDTO $dto)
    {
        return $this->repository->buscarTodosAniversariantesMesPaginado($dto);
    }

    public function atualizarComPessoa(int $idSocio, int $idPessoa, SocioAtualizarDTO $socioDTO, PessoaAtualizarDTO $pessoaDTO)
    {
        return DB::transaction(function () use ($idSocio, $idPessoa, $socioDTO, $pessoaDTO) {

            $this->pessoaRepository->atualizar($idPessoa, $pessoaDTO);

            return $this->repository->atualizar($idSocio, $socioDTO);
        });
    }

    public function criarSocioPessoa(SocioCadastrarDTO $socioDTO, PessoaCadastrarDTO $pessoaDTO)
    {
        return DB::transaction(function () use ($socioDTO, $pessoaDTO) {

            $pessoa = $this->pessoaRepository->criar($pessoaDTO);

            $socioDTO->id_pessoa = $pessoa->id_pessoa;

            return $this->repository->criar($socioDTO);
        });
    }


}
