<?php

namespace app\Repositories\Configuracao;

use app\DTOs\Configuracao\EnderecoInstituicaoAtualizarDTO;
use app\Models\Configuracao\EnderecoInstituicao;
use App\Repositories\Base\BaseRepository;

class EnderecoInstituicaoRepository extends BaseRepository
{

    public function __construct(
        EnderecoInstituicao $model
    )
    {
        parent::__construct($model);
    }

    public function buscarOPrimeiro()
    {
        return $this->model->first();
    }

    public function cadastrarOuAtualizar(EnderecoInstituicaoAtualizarDTO $dto)
    {
        $endereco = $this->model->first();

        if ($endereco) {
            $endereco->update($dto->toArrayUpdate());
        } else {
            $endereco = $this->model->create($dto->toArray());
        }

        return $endereco;
    }

}
