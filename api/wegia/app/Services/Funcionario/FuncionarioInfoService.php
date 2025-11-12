<?php

namespace app\Services\Funcionario;

use App\DTOs\Funcionario\FuncionarioOutrasInfoDTO;
use app\DTOs\Funcionario\Infos\FuncionarioInfosBuscarDTO;
use app\DTOs\Funcionario\Infos\FuncionarioListaInfoDTO;
use App\DTOs\PaginacaoDTO;
use app\Repositories\Funcionario\FuncionarioInfoRepository;
use App\Services\Base\BaseService;

class FuncionarioInfoService extends BaseService
{

    public function __construct(
        FuncionarioInfoRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarInfosPorIdFuncionario(FuncionarioInfosBuscarDTO $dto)
    {
        return  $this->repository->buscarInfosPorIdFuncionario($dto);
    }

    public function pegarListaInfo()
    {
        return $this->repository->pegarListaInfo();
    }

    public function cadastrarListaInfo(FuncionarioListaInfoDTO $dto)
    {
        return $this->repository->cadastrarListaInfo($dto);
    }
}
