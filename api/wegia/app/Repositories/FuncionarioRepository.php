<?php

namespace App\Repositories;

use App\DTOs\Funcionario\AtualizarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDependenteFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDocumentoDTO;
use App\DTOs\Funcionario\CadastrarDocumentoTipoDTO;
use App\DTOs\Funcionario\CadastrarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarQuadroHorarioDTO;
use App\DTOs\Funcionario\CadastrarRemuneracaoDTO;
use app\DTOs\Funcionario\FuncionarioBuscarDTO;
use app\DTOs\Funcionario\FuncionarioBuscarTodosDTO;
use App\Models\Funcionario\Funcionario;
use App\Models\Funcionario\FuncionarioDependente;
use App\Models\Funcionario\FuncionarioDependenteParentesco;
use App\Models\Funcionario\FuncionarioDocFuncional;
use App\Models\Funcionario\FuncionarioDocs;
use App\Models\Funcionario\FuncionarioListaInfo;
use App\Models\Funcionario\FuncionarioOutrasInfo;
use App\Models\Funcionario\FuncionarioQuadroHorario;
use App\Models\Funcionario\FuncionarioQuadroHorarioEscala;
use App\Models\Funcionario\FuncionarioQuadroHorarioTipo;
use App\Models\Funcionario\FuncionarioRemuneracao;
use App\Models\Funcionario\FuncionarioRemuneracaoTipo;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FuncionarioRepository extends BaseRepository
{

    public function __construct(
        Funcionario $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosFiltrados(FuncionarioBuscarTodosDTO $dto)
    {
        $permissao = $dto->permissao ?? null;

        return $this->model
            ->whereHas('perfil.permissoes', function ($query) use ($permissao){
                $query->where('nome', $permissao);
            })
            ->with(['pessoa', 'perfil.permissoes'])->get();
    }
    public function pegarFuncionarios(FuncionarioBuscarDTO $dto) : LengthAwarePaginator
    {
        $situacao       = $dto->id_situacao ?? null;
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;

        return Funcionario::with(['pessoa', 'perfil', 'situacao'])
            ->when(!is_null($situacao), function ($q) use ($situacao){
                return $q->where('id_situacao', $situacao);
            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('pessoa', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%")
                        ->orWhere('cpf', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'nome' || $ordenacao == 'cpf') {
                    return $q->join('pessoa', 'funcionario.id_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy("pessoa.{$ordenacao}", $tipoOrdenacao);
                } else if($ordenacao == 'perfil') {
                    return $q->join('perfil', 'funcionario.id_perfil', '=', 'perfil.id_perfil')
                    ->orderBy("perfil.cargo", $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function cadastrarFuncionario(CadastrarFuncionarioDTO $dados) : Funcionario
    {
        return Funcionario::create($dados->toArray());
    }


    public function pegarDocumentoPorId(int $id_documento) : FuncionarioDocs
    {
        return FuncionarioDocs::findOrFail($id_documento);
    }

    public function cadastrarDocumentoTipo(CadastrarDocumentoTipoDTO $documento)
    {
        return FuncionarioDocFuncional::create($documento->toArray());
    }



    public function buscarRemuneracaoPorFuncionario(int $id_funcionario, array $parametros = []) : LengthAwarePaginator
    {
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina       = $parametros['pagina'] ?? 1;

        return FuncionarioRemuneracao::with(['remuneracaoTipo'])
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


    public function buscarDependentesPorFuncionario(array $parametros, int $id_funcionario, array $with = []) : LengthAwarePaginator
    {
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;

        return FuncionarioDependente::with($with)
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


}
