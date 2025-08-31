<?php

namespace app\Repositories\Atendido;

use app\DTOs\Atendido\AtendidoOcorrenciaBuscarDTO;
use App\Models\Atendido\Ocorrencia;
use App\Models\Atendido\OcorrenciaTipos;
use App\Repositories\Base\BaseRepository;

class AtendidoOcorrenciaRepository extends BaseRepository
{

    private OcorrenciaTipos $ocorrenciaTipos;

    public function __construct(
        Ocorrencia $model,
        OcorrenciaTipos $ocorrenciaTipos
    )
    {
        parent::__construct($model);
        $this->ocorrenciaTipos = $ocorrenciaTipos;
    }

    public function buscarOcorrencias(AtendidoOcorrenciaBuscarDTO $dto)
    {
        $id_atendido    = $dto->id_atendido;
        $tipo           = $dto->id_tipo ?? null;
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $with           = isset($dto->with) ? explode(',', $dto->with) : [];

        return $this->model
            ->with($with)
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

    public function buscarOcorrenciaTipos()
    {
        return $this->ocorrenciaTipos
                ->all();
    }
}
