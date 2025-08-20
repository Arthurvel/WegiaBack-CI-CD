<?php

namespace Modules\Memorando\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Memorando\app\Models\Despacho;
use Modules\Memorando\app\Models\Views\DestinatarioAtual;

class DespachoRepository extends BaseRepository
{
    public function __construct(
        Despacho $model
    )
    {
        parent::__construct($model);
    }

    public function buscarIdsQueUsuarioParticipou(int $id)
    {
        return Despacho::where('id_remetente', $id)
            ->orWhere('id_destinatario', $id)
            ->pluck('id_memorando')
            ->unique()
            ->toArray();
    }

    public function ultimoDestinatario(int $id) : Despacho
    {
        return Despacho::with(['memorando'])
            ->where('id_memorando', $id)
            ->orderByDesc('data')
            ->first();
    }

}
