<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\DTO\TipoMovimentacaoBuscarTodosParamsDTO;
use Modules\Material\app\DTO\TipoMovimentacaoBuscarTodosSemPaginacaoParamsDTO;
use Modules\Material\app\Models\TipoMovimentacao;

class TipoMovimentacaoRepository extends BaseRepository
{
    public function __construct(
        TipoMovimentacao $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosFiltro(TipoMovimentacaoBuscarTodosSemPaginacaoParamsDTO $dto)
    {
        $tipo = $dto->tipo ?? null;

        return $this->model
            ->when($tipo, function ($query) use ($tipo) {
                return $query->where('tipo', $tipo);
            })
            ->get();
    }

    public function buscarTodosPaginado(TipoMovimentacaoBuscarTodosParamsDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;

        return $this->model
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('nome', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy("$ordenacao", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
