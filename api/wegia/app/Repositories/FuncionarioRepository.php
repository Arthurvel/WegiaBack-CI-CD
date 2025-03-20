<?php

namespace App\Repositories;

use App\DTOs\Funcionario\AtualizarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDocumentoDTO;
use App\DTOs\Funcionario\FuncionarioDTO;
use App\Models\Funcionario;
use App\Models\FuncionarioDocs;
use Illuminate\Pagination\LengthAwarePaginator;

class FuncionarioRepository
{

    public function pegarFuncionarios(array $parametros = []) : LengthAwarePaginator
    {
        $situacao       = $parametros['id_situacao'] ?? null;
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;

        return Funcionario::with(['pessoa', 'cargo', 'situacao'])
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
                } else if($ordenacao == 'cargo') {
                    return $q->join('cargo', 'funcionario.id_cargo', '=', 'cargo.id_cargo')
                    ->orderBy("cargo.cargo", $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function pegarFuncionarioPorId(int $id) : Funcionario
    {
        return Funcionario::findOrFail($id);
    }

    public function cadastrarFuncionario(FuncionarioDTO $dados) : Funcionario
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
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;

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
}