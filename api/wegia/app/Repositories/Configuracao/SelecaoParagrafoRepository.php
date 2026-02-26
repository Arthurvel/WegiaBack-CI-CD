<?php

namespace app\Repositories\Configuracao;

use App\Enums\SelecaoParagrafoEnum;
use app\Models\Configuracao\SelecaoParagrafo;
use App\Repositories\Base\BaseRepository;

class SelecaoParagrafoRepository extends BaseRepository
{

    public function __construct(
        SelecaoParagrafo $model
    )
    {
        parent::__construct($model);
    }

    public function buscarPorNome(SelecaoParagrafoEnum $enum)
    {
        return $this->model
            ->where('nome_campo', $enum->value )
            ->firstOrFail();
    }

}
