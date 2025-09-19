<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeEnfermidadeBuscarParamsDTO;
use Modules\Saude\app\Models\SaudeEnfermidades;

class SaudeEnfermidadesRespository extends BaseRepository
{

    public function __construct(
        SaudeEnfermidades $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginacao(SaudeEnfermidadeBuscarParamsDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $status         = $dto->status ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $id_fichamedica = $dto->id_fichamedica;

        return $this->model
            ->with('cid')
            ->where('id_fichamedica', $id_fichamedica)
            ->when(!is_null($status), function ($q) use ($status) {
                return $q->where('status', $status);
            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('cid', function ($q2) use ($buscar) {
                    $q2->where('CID', 'like', "%{$buscar}%")
                        ->orWhere('descricao', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'tipo') {
                    return $q->join('saude_exame_tipos', 'saude_exames.id_exame_tipo', '=', 'saude_exame_tipos.id_exame_tipo')
                        ->orderBy("saude_exame_tipos.{$ordenacao}", $tipoOrdenacao);
                } else {
                    return $q->orderBy($ordenacao, $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }


}
