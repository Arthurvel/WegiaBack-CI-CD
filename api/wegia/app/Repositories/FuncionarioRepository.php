<?php

namespace App\Repositories;

use App\DTOs\Funcionario\CadastrarDocumentoDTO;
use App\DTOs\Funcionario\FuncionarioDTO;
use App\DTOs\PaginacaoDTO;
use App\Models\Funcionario;
use App\Models\FuncionarioDocs;

class FuncionarioRepository
{

    public function pegarFuncionarios(array $parametros = []) : PaginacaoDTO
    {
        $situacao       = $parametros['id_situacao'] ?? null;
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;

        $funcionarios =  Funcionario::with(['pessoa', 'cargo', 'situacao'])
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

        $itens = collect($funcionarios->items())->map(function ($funcionario) {
            return FuncionarioDTO::fromArray($funcionario->toArray());
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $funcionarios->currentPage(),
            $funcionarios->lastPage(),
            $funcionarios->total(),
            $funcionarios->perPage()
        );
    }

    public function cadastrarFuncionario(FuncionarioDTO $dados) : Funcionario
    {
        return Funcionario::create($dados->toArray());
    }

    public function cadastrarDocumento(CadastrarDocumentoDTO $dados) : FuncionarioDocs
    {
        return FuncionarioDocs::create($dados->toArray());
    }

}