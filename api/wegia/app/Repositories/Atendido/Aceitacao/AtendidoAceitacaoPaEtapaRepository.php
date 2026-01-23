<?php

namespace app\Repositories\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaBuscarTodosDTO;
use app\Models\Atendido\Aceitacao\AtendidoAceitacaoPaEtapa;
use App\Repositories\Base\BaseRepository;

class AtendidoAceitacaoPaEtapaRepository extends BaseRepository
{

    public function __construct(
        AtendidoAceitacaoPaEtapa $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(AtendidoAceitacaoPaEtapaBuscarTodosDTO $dto)
    {
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $status          = $dto->status ?? null;
        $id_processo     = $dto->id_processo;

        return $this->model
            ->with(['status', 'arquivos'])
            ->where('id_processo', $id_processo)
            ->when($status, function ($query) use ($status) {
                $query->where('id_status', $status);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
