<?php

namespace app\Repositories\Funcionario;

use app\DTOs\Funcionario\QuadroHorario\FuncionarioQuadroHorarioCadastrarDTO;
use App\Models\Funcionario\FuncionarioQuadroHorario;
use App\Models\Funcionario\FuncionarioQuadroHorarioEscala;
use App\Models\Funcionario\FuncionarioQuadroHorarioTipo;
use App\Repositories\Base\BaseRepository;

class FuncionarioQuadroHorarioRepository extends BaseRepository
{

    protected FuncionarioQuadroHorarioEscala $funcionarioQuadroHorarioEscala;
    protected FuncionarioQuadroHorarioTipo $funcionarioQuadroHorarioTipo;

    public function __construct(
        FuncionarioQuadroHorario $model,
        FuncionarioQuadroHorarioEscala $funcionarioQuadroHorarioEscala,
        FuncionarioQuadroHorarioTipo $funcionarioQuadroHorarioTipo
    )
    {
        parent::__construct($model);
        $this->funcionarioQuadroHorarioEscala = $funcionarioQuadroHorarioEscala;
        $this->funcionarioQuadroHorarioTipo = $funcionarioQuadroHorarioTipo;
    }

    public function buscarQuadroHorarioPorFuncionario(int $id_funcionario)
    {
        return $this->model
            ->with(['quadroHorarioTipo', 'quadroHorarioEscala'])
            ->where('id_funcionario', $id_funcionario)
            ->firstOrFail();
    }

    public function cadastrarQuadroHorario(FuncionarioQuadroHorarioCadastrarDTO $dto)
    {
        return $this->model
            ->updateOrCreate(
                ['id_funcionario' => $dto->id_funcionario],
                $dto->toArray()
            );
    }

    public function buscarEscalaQuadroHorario()
    {
        return $this->funcionarioQuadroHorarioEscala->all();
    }

    public function buscarTipoQuadroHorario()
    {
        return $this->funcionarioQuadroHorarioTipo->all();
    }

}
