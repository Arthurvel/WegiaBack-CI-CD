<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeSinaisVitaisBuscarTodosParamsDTO;
use Modules\Saude\app\Models\SaudeSinaisVitais;

class SaudeSinaisVitaisRespository  extends BaseRepository
{

    public function __construct(
        SaudeSinaisVitais $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(SaudeSinaisVitaisBuscarTodosParamsDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $id_ficha_medica = $dto->id_fichamedica;

        return $this->model
            ->where('id_fichamedica', $id_ficha_medica)
            ->with([
                'funcionario' => function($q) {
                    $q->select('id_funcionario', 'id_pessoa');
                    $q->with(['pessoa:id_pessoa,nome']);
                }
            ])
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('funcionario.pessoa', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                if($ordenacao == 'nome') {
                    return $q->join('funcionario', 'saude_sinais_vitais.id_funcionario', '=', 'funcionario.id_funcionario')
                        ->join('pessoa', 'funcionario.id_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy('pessoa.nome', $tipoOrdenacao)
                        ->select('saude_sinais_vitais.*');
                }
                return $q->orderBy("{$ordenacao}", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}

