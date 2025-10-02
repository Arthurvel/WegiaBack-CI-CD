<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeFichaMedicaAlergiaBuscarTodosParamsDTO;
use Modules\Saude\app\Models\SaudeFichaMedicaAlergia;

class SaudeFichaMedicaAlergiaRepository extends BaseRepository
{

    public function __construct(
        SaudeFichaMedicaAlergia $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(SaudeFichaMedicaAlergiaBuscarTodosParamsDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $id_fichamedica = $dto->id_fichamedica;

        return $this->model
            ->with('alergias')
            ->where('id_fichamedica', $id_fichamedica)
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                $q->whereHas('alergias', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                if ($ordenacao === 'nome') {
                    $q->join('saude_alergia as a', 'a.id_alergia', '=', 'saude_fichamedica_alergia.id_alergia')
                        ->orderBy("a.nome", $tipoOrdenacao)
                        ->select('saude_fichamedica_alergia.*');
                }
                return $q;
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
