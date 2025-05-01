<?php

namespace App\Repositories;

use App\DTOs\Atendido\CriarOcorrenciaDocDTO;
use App\DTOs\Atendido\CriarOcorrenciaDTO;
use App\Models\Atendido\Atendido;
use App\Models\Atendido\AtendidoStatus;
use App\Models\Atendido\AtendidoTipo;
use App\Models\Atendido\Ocorrencia;
use App\Models\Atendido\OcorrenciaDoc;
use App\Models\Atendido\OcorrenciaTipos;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AtendimentoRepository
{
    
    public function buscarAtendimentos(array $parametros) : LengthAwarePaginator
    {
        $status         = $parametros['id_status'] ?? null;
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;
        $with           = isset($parametros['with']) ? explode(',', $parametros['with']) : [];

        return Atendido::with($with)
            ->when(!is_null($status), function ($q) use ($status){
                return $q->where('atendido_status_idatendido_status', $status);
            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('pessoa', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%")
                        ->orWhere('cpf', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'nome' || $ordenacao == 'cpf') {
                    return $q->join('pessoa', 'atendido.pessoa_id_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy("pessoa.{$ordenacao}", $tipoOrdenacao);
                } 
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarAtendidoPorId(int $id, $with = []) : Atendido
    {
        return Atendido::with($with)
            ->findOrFail($id);
    }

    public function cadastrarAtendido(Atendido $dados) : Atendido
    {
        return Atendido::create($dados->toArray());
    }

    public function buscarTipoAtendimento() : Collection
    {
        return AtendidoTipo::all();
    }

    public function buscarStatusAtendimento() : Collection
    {
        return AtendidoStatus::all();
    }

    public function buscarOcorrencias(int $id_atendido, array $parametros) : LengthAwarePaginator
    {
        $tipo           = $parametros['id_tipo'] ?? null;
        $buscar         = $parametros['buscar'] ?? null;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;
        $with           = isset($parametros['with']) ? explode(',', $parametros['with']) : [];
        
        return Ocorrencia::with($with)
            ->when(!is_null($tipo), function ($q) use ($tipo){
                return $q->where('atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos', $tipo);
            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('tipos', function ($q2) use ($buscar) {
                    $q2->where('descricao', 'like', "%{$buscar}%");
                })->orWhere('data', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                if($ordenacao == 'tipo') {
                    return $q->join(
                            'atendido_ocorrencia_tipos', 
                            'atendido_ocorrencia.atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos', '=', 'atendido_ocorrencia_tipos.idatendido_ocorrencia_tipos'
                    )
                    ->orderBy("atendido_ocorrencia_tipos.descricao", $tipoOrdenacao);
                } else {
                    return $q->orderBy("{$ordenacao}", $tipoOrdenacao);
                }
            })
            ->where('atendido_idatendido', $id_atendido)
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarOcorrenciaTipos() : Collection
    {
        return OcorrenciaTipos::all();
    }

    public function cadastrarOcorrencia(CriarOcorrenciaDTO $dados) : Ocorrencia
    {
        return Ocorrencia::create($dados->toArray());
    }

    public function cadastrarAtendimentoDoc(CriarOcorrenciaDocDTO $dados) : OcorrenciaDoc
    {
        return OcorrenciaDoc::create($dados->toArray());
    }

}