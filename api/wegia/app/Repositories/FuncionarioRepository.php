<?php

namespace App\Repositories;

use App\DTOs\Funcionario\AtualizarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDependenteFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDocumentoDTO;
use App\DTOs\Funcionario\CadastrarDocumentoTipoDTO;
use App\DTOs\Funcionario\CadastrarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarQuadroHorarioDTO;
use App\DTOs\Funcionario\CadastrarRemuneracaoDTO;
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class FuncionarioRepository
{

    public function buscarTodos(String $permissao)
    {
        return Funcionario::whereHas('perfil.permissoes', function ($query) use ($permissao){
            $query->where('nome', $permissao);
        })->with(['pessoa', 'perfil.permissoes'])->get();
    }
    public function pegarFuncionarios(array $parametros = []) : LengthAwarePaginator
    {
        $situacao       = $parametros['id_situacao'] ?? null;
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;

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

    public function pegarFuncionarioPorId(int $id, $with = []) : Funcionario
    {
        return Funcionario::with($with)
            ->findOrFail($id);
    }

    public function cadastrarFuncionario(CadastrarFuncionarioDTO $dados) : Funcionario
    {
        return Funcionario::create($dados->toArray());
    }

    public function atualizarFuncionario(AtualizarFuncionarioDTO $dados, int $id_funcionario) : Funcionario
    {
        $funcionario = $this->pegarFuncionarioPorId($id_funcionario);

        $funcionario->update($dados->toArray());
        $funcionario->save();

        return $funcionario;
    }

    public function cadastrarDocumento(CadastrarDocumentoDTO $dados) : FuncionarioDocs
    {
        return FuncionarioDocs::create($dados->toArray());
    }

    public function pegarDocumentos(array $parametros = [], $id_funcionario = null) : LengthAwarePaginator
    {
        $buscar         = !empty($parametros['buscar']) ? $parametros['buscar'] : null;
        $ordenacao      = !empty($parametros['ordenacao'])? $parametros['ordenacao'] : null;
        $tipoOrdenacao  = !empty($parametros['tipoOrdenacao'])? $parametros['tipoOrdenacao'] : 'ASC';
        $itensPorPagina = !empty($parametros['itensPorPagina'])? $parametros['itensPorPagina'] : 10;
        $pagina         = !empty($parametros['pagina'])? $parametros['pagina'] : 1;

        return FuncionarioDocs::with(['funcionarioDocFuncional'])
            ->when(!is_null($id_funcionario), function ($q) use ($id_funcionario) {

                return $q->where('id_funcionario', $id_funcionario);

            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {

                return $q->where(function ($q2) use ($buscar) {
                    $q2->whereHas('funcionarioDocFuncional', function ($q3) use ($buscar) {
                        $q3->where('nome_docfuncional', 'like', "%{$buscar}%");
                    });
                })->orWhere('data', 'like', "%{$buscar}%");

            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'nome_docfuncional') {
                    return $q->join('funcionario_docfuncional', 'funcionario_docs.id_docfuncional', '=', 'funcionario_docfuncional.id_docfuncional')
                        ->orderBy("funcionario_docfuncional.nome_docfuncional", $tipoOrdenacao);
                }

                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function pegarDocumentoPorId(int $id_documento) : FuncionarioDocs
    {
        return FuncionarioDocs::findOrFail($id_documento);
    }

    public function deletarDocumento(int $id_documento) : bool
    {
        return $this->pegarDocumentoPorId($id_documento)->delete();
    }

    public function buscarDocumentoTipo() : Collection
    {
        return FuncionarioDocFuncional::get();
    }

    public function cadastrarDocumentoTipo(CadastrarDocumentoTipoDTO $documento)
    {
        return FuncionarioDocFuncional::create($documento->toArray());
    }

    public function buscarInfosPorIdFuncionario(int $id_funcionario, array $parametros = []) : LengthAwarePaginator
    {
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;

        return FuncionarioOutrasInfo::with(['listaInfo'])
            ->where('funcionario_id_funcionario', $id_funcionario)
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                $q->where(function ($query) use ($buscar) {
                    $query->whereHas('listaInfo', function ($q2) use ($buscar) {
                        $q2->where('descricao', 'like', "%{$buscar}%");
                    })
                    ->orWhere('dado', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'descricao') {
                    return $q->join(
                        'funcionario_listainfo',
                        'funcionario_outrasinfo.funcionario_listainfo_idfuncionario_listainfo',
                        '=',
                        'funcionario_listainfo.idfuncionario_listainfo'
                    )
                        ->orderBy("funcionario_listainfo.{$ordenacao}", $tipoOrdenacao);
                } else {
                    return $q->orderBy($ordenacao, $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function cadastrarInfo(string $dado, int $id_funcionario, int $id_funcionario_lista_info) : FuncionarioOutrasInfo
    {
        return FuncionarioOutrasInfo::create([
            "dado" => $dado,
            "funcionario_id_funcionario" => $id_funcionario,
            "funcionario_listainfo_idfuncionario_listainfo" => $id_funcionario_lista_info
        ]);
    }

    public function deletarInfo(int $id_funcionario_outrasinfo) : bool
    {
        return FuncionarioOutrasInfo::findOrFail($id_funcionario_outrasinfo)->delete();
    }

    public function pegarListaInfo() : Collection
    {
        return FuncionarioListaInfo::all();
    }

    public function cadastrarListaInfo(string $descricao) : FuncionarioListaInfo
    {
        return FuncionarioListaInfo::create(['descricao' => $descricao]);
    }

    public function pegarRemuneracaoTipo() : Collection
    {
        return FuncionarioRemuneracaoTipo::all();
    }

    public function cadastrarRemuneracaoTipo(string $descricao) : FuncionarioRemuneracaoTipo
    {
        return FuncionarioRemuneracaoTipo::create(['descricao' => $descricao]);
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

    public function cadastrarRemuneracao(CadastrarRemuneracaoDTO $remuneracao) : FuncionarioRemuneracao
    {
        return FuncionarioRemuneracao::create($remuneracao->toArray());
    }

    public function deletarRemuneracao(int $id_remuneracao) : bool
    {
        return FuncionarioRemuneracao::findOrFail($id_remuneracao)->delete();
    }

    public function buscarRemuneracaoTotalPorFuncionario(int $id_funcionario)
    {
        return FuncionarioRemuneracao::where('funcionario_id_funcionario', $id_funcionario)
            ->sum('valor');
    }

    public function buscarQuadroHorarioPorFuncionario(int $id_funcionario) : FuncionarioQuadroHorario
    {
        return FuncionarioQuadroHorario::with(['quadroHorarioTipo', 'quadroHorarioEscala'])
            ->where('id_funcionario', $id_funcionario)
            ->first();
    }

    public function cadastrarQuadroHorario(CadastrarQuadroHorarioDTO $dados) : FuncionarioQuadroHorario
    {
        return FuncionarioQuadroHorario::updateOrCreate(
            ['id_funcionario' => $dados->id_funcionario],
            $dados->toArray()
        );
    }

    public function buscarEscalaQuadroHorario() : Collection
    {
        return FuncionarioQuadroHorarioEscala::all();
    }

    public function buscarTipoQuadroHorario() : Collection
    {
        return FuncionarioQuadroHorarioTipo::all();
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

    public function cadastrarDependente(CadastrarDependenteFuncionarioDTO $dados) :FuncionarioDependente
    {
        return FuncionarioDependente::create($dados->toArray());
    }

    public function excluirDependente(int $id_dependente) : bool
    {
        return FuncionarioDependente::findOrFail($id_dependente)->delete();
    }

    public function buscarDependenteParentesco() : Collection
    {
        return FuncionarioDependenteParentesco::get();
    }

    public function cadastrarDependenteParentesco(array $dados) : FuncionarioDependenteParentesco
    {
        return FuncionarioDependenteParentesco::create($dados);
    }
}
