<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
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
}
