<?php

namespace app\Services\Funcionario;

use app\DTOs\Funcionario\Dependente\FuncionarioDependenteBuscarDTO;
use app\DTOs\Funcionario\Dependente\FuncionarioDependenteParentescoCadastrarDTO;
use app\Repositories\Funcionario\FuncionarioDependenteRepository;
use App\Services\Base\BaseService;

class FuncionarioDependenteService extends BaseService
{

    public function __construct(
        FuncionarioDependenteRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarDependentesPorFuncionario(FuncionarioDependenteBuscarDTO $dto)
    {
        return $this->repository->buscarDependentesPorFuncionario($dto);
    }

    public function buscarDependenteParentesco()
    {
        return $this->repository->buscarDependenteParentesco();
    }

    public function cadastrarDependenteParentesco(FuncionarioDependenteParentescoCadastrarDTO $dto)
    {
        return $this->repository->cadastrarDependenteParentesco($dto);
    }

}
