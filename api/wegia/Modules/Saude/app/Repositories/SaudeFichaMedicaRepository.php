<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeFichaMedicaParamsDTO;
use Modules\Saude\app\Models\SaudeFichaMedica;

class SaudeFichaMedicaRepository extends BaseRepository
{

    public function __construct(
        SaudeFichaMedica $model
    )
    {
        parent::__construct($model);
    }

    public function buscarFichaMedica(SaudeFichaMedicaParamsDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;

        return $this->model
            ->select('saude_fichamedica.id_fichamedica', 'saude_fichamedica.id_pessoa')
            ->with(['pessoa:id_pessoa,nome'])
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('pessoa', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                if($ordenacao == 'nome') {
                    return $q->join('pessoa', 'saude_fichamedica.id_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy("pessoa.{$ordenacao}", $tipoOrdenacao);
                }
                return $q;
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
