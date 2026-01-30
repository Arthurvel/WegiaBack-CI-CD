<?php

namespace app\Services\Configuracao;

use app\DTOs\Configuracao\EnderecoInstituicaoAtualizarDTO;
use app\Repositories\Configuracao\EnderecoInstituicaoRepository;
use App\Services\Base\BaseService;

class EnderecoInstituicaoService extends BaseService
{

    public function __construct(
        EnderecoInstituicaoRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarOPrimeiro()
    {
        return $this->repository->buscarOPrimeiro();
    }

    public function cadastrarOuAtualizar(EnderecoInstituicaoAtualizarDTO $dto)
    {
        return $this->repository->cadastrarOuAtualizar($dto);
    }

}
