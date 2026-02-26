<?php

namespace app\Repositories\Configuracao;

use app\Models\Configuracao\CampoImagem;
use App\Repositories\Base\BaseRepository;

class CampoImagemRepository extends BaseRepository
{

    public function __construct(
        CampoImagem $model
    )
    {
        parent::__construct($model);
    }

    public function buscarPorNomeCampo(string $nomeCampo)
    {
        return $this->model
            ->with(['imagens'])
            ->where('nome_campo', $nomeCampo)
            ->get();
    }
}
