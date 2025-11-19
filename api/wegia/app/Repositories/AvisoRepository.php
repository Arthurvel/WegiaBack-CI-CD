<?php

namespace App\Repositories;

use App\DTOs\Aviso\AvisoBuscarTodosParamsDTO;
use App\Models\Aviso;
use App\Repositories\Base\BaseRepository;

class AvisoRepository extends BaseRepository
{

    public function __construct(
        Aviso $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosFiltro(AvisoBuscarTodosParamsDTO $dto)
    {
        $ativo = isset($dto->ativo) ? filter_var($dto->ativo, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) : null;
        $idPessoa = $dto->id_pessoa ?? null;
        $titulo = $dto->titulo ?? null;
        $nivel = $dto->nivel ?? null;
        $pagina = $dto->pagina ?? 1;
        $itensPorPagina = $dto->itensPorPagina ?? 10;

        return $this->model
            ->when(!is_null($ativo), function ($q) use ($ativo) {
                return $q->where('ativo', $ativo);
            })
            ->when(!is_null($idPessoa), function ($q) use ($idPessoa) {
                return $q->where('id_pessoa', $idPessoa);
            })
            ->when(!is_null($titulo), function ($q) use ($titulo) {
                return $q->where('titulo', 'like', '%' . $titulo . '%');
            })
            ->when(!is_null($nivel), function ($q) use ($nivel) {
                return $q->where('nivel', $nivel);
            })
            ->orderBy('data_criacao', 'desc')
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }


    public function desativar(int $id)
    {
        return $this->model->where('id_aviso', $id)
            ->update(['ativo' => false]);
    }

}
