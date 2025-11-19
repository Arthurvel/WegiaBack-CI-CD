<?php

namespace app\Repositories\Funcionario;

use app\DTOs\Funcionario\Dependente\FuncionarioDependenteBuscarDTO;
use app\DTOs\Funcionario\Dependente\FuncionarioDependenteParentescoCadastrarDTO;
use App\Models\Funcionario\FuncionarioDependente;
use App\Models\Funcionario\FuncionarioDependenteParentesco;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class FuncionarioDependenteRepository extends BaseRepository
{

    private FuncionarioDependenteParentesco $funcionarioDependenteParentesco;

    public function __construct(
        FuncionarioDependente $model,
        FuncionarioDependenteParentesco $funcionarioDependenteParentesco
    )
    {
        parent::__construct($model);
        $this->funcionarioDependenteParentesco = $funcionarioDependenteParentesco;
    }

    public function buscarDependentesPorFuncionario(FuncionarioDependenteBuscarDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $id_funcionario = $dto->id_funcionario ?? null;

        return $this->model
            ->with(['parentesco', 'pessoa'])
            ->where('id_funcionario', $id_funcionario)
            ->when(!is_null($buscar), function ($q) use ($buscar, $id_funcionario) {
                return $q->where(function ($query) use ($buscar, $id_funcionario) {

                    $query->where('id_funcionario', $id_funcionario)
                        ->where(function ($subQuery) use ($buscar) {
                            $subQuery->whereHas('pessoa', function ($q2) use ($buscar) {
                                $q2->where('nome', 'like', "%{$buscar}%")
                                    ->orWhere('cpf', 'like', "%{$buscar}%");
                            })
                                ->orWhereHas('parentesco', function ($q3) use ($buscar) {
                                    $q3->where('descricao', 'like', "%{$buscar}%");
                                });
                        });

                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'nome' || $ordenacao == 'cpf') {
                    return $q->join('pessoa', 'funcionario_dependentes.id_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy("pessoa.{$ordenacao}", $tipoOrdenacao);
                } else if($ordenacao == 'parentesco') {
                    return $q->join('funcionario_dependente_parentesco', 'funcionario_dependentes.id_parentesco', '=', 'funcionario_dependente_parentesco.id_parentesco')
                        ->orderBy("funcionario_dependente_parentesco.id_parentesco", $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }


    public function buscarDependenteParentesco() : Collection
    {
        return $this->funcionarioDependenteParentesco
            ->get();
    }

    public function cadastrarDependenteParentesco(FuncionarioDependenteParentescoCadastrarDTO $dto)
    {
        return $this->funcionarioDependenteParentesco
            ->create($dto->toArray());
    }
}
