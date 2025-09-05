<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\DTO\AtendimentoBuscarTodosDTO;
use Modules\Pet\app\Models\Atendimento;

class AtendimentoRepository extends BaseRepository
{

    public function __construct(
        Atendimento $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(AtendimentoBuscarTodosDTO $dto)
    {
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $id_ficha_medica = $dto->id_ficha_medica;

        return $this->model
            ->with(['medicacao.medicamento'])
            ->where('id_ficha_medica', $id_ficha_medica)
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

}
