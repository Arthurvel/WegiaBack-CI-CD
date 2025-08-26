<?php

namespace app\Repositories\Funcionario;

use app\DTOs\Funcionario\Remuneracao\FuncionarioRemuneracaoBuscarDTO;
use app\DTOs\Funcionario\Remuneracao\FuncionarioRemuneracaoTipoCadastrarDTO;
use App\Models\Funcionario\FuncionarioRemuneracao;
use App\Models\Funcionario\FuncionarioRemuneracaoTipo;
use App\Repositories\Base\BaseRepository;

class FuncionarioRemuneracaoRepository extends BaseRepository
{

    protected FuncionarioRemuneracaoTipo $funcionarioRemuneracaoTipo;

    public function __construct(
        FuncionarioRemuneracao $model,
        FuncionarioRemuneracaoTipo $funcionarioRemuneracaoTipo
    )
    {
        parent::__construct($model);
        $this->funcionarioRemuneracaoTipo = $funcionarioRemuneracaoTipo;
    }

    public function buscarRemuneracaoPorFuncionario(FuncionarioRemuneracaoBuscarDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $id_funcionario = $dto->id_funcionario ?? null;

        return $this->model
            ->with(['remuneracaoTipo'])
            ->where('funcionario_id_funcionario', $id_funcionario)
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                $q->where(function ($query) use ($buscar) {
                    $query->whereHas('remuneracaoTipo', function ($q2) use ($buscar) {
                        $q2->where('descricao', 'like', "%{$buscar}%");
                    })
                        ->orWhere('valor', 'like', "%{$buscar}%")
                        ->orWhere('inicio', 'like', "%{$buscar}%")
                        ->orWhere('fim', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                if ($ordenacao == 'descricao') {
                    return $q->join(
                        'funcionario_remuneracao_tipo',
                        'funcionario_remuneracao.funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo',
                        '=',
                        'funcionario_remuneracao_tipo.idfuncionario_remuneracao_tipo'
                    )
                        ->orderBy("funcionario_remuneracao_tipo.{$ordenacao}", $tipoOrdenacao);
                } else {
                    return $q->orderBy($ordenacao, $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);

    }


    public function buscarRemuneracaoTotalPorFuncionario(int $id_funcionario)
    {
        return $this->model
            ->where('funcionario_id_funcionario', $id_funcionario)
            ->sum('valor');
    }

    public function pegarRemuneracaoTipo()
    {
        return $this->funcionarioRemuneracaoTipo->all();
    }

    public function cadastrarRemuneracaoTipo(FuncionarioRemuneracaoTipoCadastrarDTO $dto)
    {
        return $this->funcionarioRemuneracaoTipo->create($dto->toArray());
    }
}
