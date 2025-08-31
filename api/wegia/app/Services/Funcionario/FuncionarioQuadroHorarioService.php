<?php

namespace app\Services\Funcionario;

use App\DTOs\Funcionario\FuncionarioQuadroHorarioDTO;
use app\DTOs\Funcionario\QuadroHorario\FuncionarioQuadroHorarioCadastrarDTO;
use app\Repositories\Funcionario\FuncionarioQuadroHorarioRepository;
use App\Services\Base\BaseService;

class FuncionarioQuadroHorarioService extends BaseService
{

    public function __construct(
        FuncionarioQuadroHorarioRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarQuadroHorarioPorFuncionario(int $id_funcionario)
    {
        return $this->repository->buscarQuadroHorarioPorFuncionario($id_funcionario);
    }

    public function cadastrarQuadroHorario(FuncionarioQuadroHorarioCadastrarDTO $dto)
    {
        return $this->repository->cadastrarQuadroHorario($dto);
    }

    public function buscarEscalaQuadroHorario()
    {
        return $this->repository->buscarEscalaQuadroHorario();
    }

    public function buscarTipoQuadroHorario()
    {
        return $this->repository->buscarTipoQuadroHorario();
    }

}
