<?php

namespace Modules\Memorando\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Memorando\app\DTO\MemorandoBuscarTodosDTO;
use Modules\Memorando\app\Models\Memorando;
use Modules\Memorando\app\Models\Views\DestinatarioAtual;

class MemorandoRepository extends BaseRepository
{
    private DestinatarioAtual $destinatarioAtualView;

    public function __construct(
        Memorando $model,
        DestinatarioAtual $destinatarioAtualView
    )
    {
        parent::__construct($model);
        $this->destinatarioAtualView = $destinatarioAtualView;
    }

    public function buscarTodosFiltro(MemorandoBuscarTodosDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $status         = $dto->status ?? null;
        $destinatario = filter_var($dto->destinatario ?? false, FILTER_VALIDATE_BOOLEAN);
        $remetente = filter_var($dto->remetente ?? false, FILTER_VALIDATE_BOOLEAN);
        $id_pessoa      = $dto->id_pessoa ?? null;
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;

        return $this->destinatarioAtualView
            ->when(!is_null($status), function ($q) use ($status) {
                return $q->where('status_memorando', $status);
            })
            ->when(!is_null($destinatario), function ($q) use ($id_pessoa, $destinatario) {
                if ($destinatario) {
                    return $q->where('id_destinatario', $id_pessoa);
                }
            })
            ->when(!is_null($remetente), function ($q) use ($id_pessoa, $remetente) {
                if ($remetente) {
                    return $q->where('id_remetente', $id_pessoa);
                }
            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('titulo', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function memorandosParticipados(MemorandoBuscarTodosDTO $dto, array $ids)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? 'data';
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'DESC';
        $status         = $dto->status ?? null;
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;

        return $this->destinatarioAtualView
            ->whereIn('id_memorando', $ids)
            ->when(!is_null($status), function ($q) use ($status) {
                return $q->where('status_memorando', $status);
            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('titulo', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarPorId(int $id)
    {
        return $this->model
            ->with(['despachos.anexos', 'despachos.remetente', 'despachos.destinatario'])
            ->where('id_memorando', $id)
            ->firstOrFail();
    }
}
