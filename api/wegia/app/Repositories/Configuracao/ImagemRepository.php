<?php

namespace app\Repositories\Configuracao;

use app\Models\Configuracao\Imagem;
use App\Repositories\Base\BaseRepository;

class ImagemRepository extends BaseRepository
{

    public function __construct(
        Imagem $model
    )
    {
        parent::__construct($model);
    }

    public function nomeExiste($nome)
    {
        return $this->model->where('nome', $nome)->exists();
    }

    public function quantidadeExistenteDoNome($nome)
    {
        return $this->model->where('nome', 'like', $nome . ' (%)')
            ->get()
            ->map(function($imagem) use ($nome) {
                if (preg_match('/\((\d+)\)$/', $imagem->nome, $matches)) {
                    return (int) $matches[1];
                }
                return 0;
            })
            ->max();
    }

}
