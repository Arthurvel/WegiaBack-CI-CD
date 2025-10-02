<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeMedicacaoBuscarTodosParamsDTO;
use Modules\Saude\app\Models\SaudeMedicacao;

class SaudeMedicacaoRepository extends BaseRepository
{

    public function __construct(
        SaudeMedicacao $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(SaudeMedicacaoBuscarTodosParamsDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $status          = $dto->status ?? null;
        $id_ficha_medica = $dto->id_fichamedica;

        return $this->model
            ->whereHas('atendimento', function($q) use ($id_ficha_medica) {
                $q->where('id_fichamedica', $id_ficha_medica);
            })
            ->when(!is_null($status), function ($q) use ($status) {
                return $q->where("status", $status);
            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('medicamento', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy("saude_medicacao.$ordenacao", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

}
