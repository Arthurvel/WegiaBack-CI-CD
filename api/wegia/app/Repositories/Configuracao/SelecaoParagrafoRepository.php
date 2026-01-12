<?php

namespace app\Repositories\Configuracao;

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

    public function buscarPorDescricao(string $descricao)
    {
        return $this->model
            ->where('descricao', $descricao )
            ->get();
    }

}
