<?php

namespace app\Services\Funcionario;

use app\DTOs\Funcionario\Remuneracao\FuncionarioRemuneracaoBuscarDTO;
use app\DTOs\Funcionario\Remuneracao\FuncionarioRemuneracaoTipoCadastrarDTO;
use app\Repositories\Funcionario\FuncionarioRemuneracaoRepository;
use App\Services\Base\BaseService;

class FuncionarioRemuneracaoService extends BaseService
{

    public function __construct(
        FuncionarioRemuneracaoRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarRemuneracaoPorFuncionario(FuncionarioRemuneracaoBuscarDTO $dto)
    {
        return $this->repository->buscarRemuneracaoPorFuncionario($dto);
    }

    public function buscarRemuneracaoTotalPorFuncionario(int $id_funcionario)
    {
        return $this->repository->buscarRemuneracaoTotalPorFuncionario($id_funcionario);
    }

    public function pegarRemuneracaoTipo()
    {
        return $this->repository->pegarRemuneracaoTipo();
    }

    public function cadastrarRemuneracaoTipo(FuncionarioRemuneracaoTipoCadastrarDTO $dto)
    {
        return $this->repository->cadastrarRemuneracaoTipo($dto);
    }
}
