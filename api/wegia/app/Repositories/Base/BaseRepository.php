<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel da Model
 * @template TCriar objeto de dto
 * @template TAtualizar objeto de dto
 */
abstract class BaseRepository
{
    /** @var TModel */
    protected $model;

    /**
     * @param TModel $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param TCriar $data
     * @return TModel
     */
    public function criar(object $data)
    {
        return $this->model->create($data->toArray());
    }

    /**
     * @param array<int, TCriar|array> $dados
     * @return bool
     */
    public function criarEmMassa(array $dados): bool
    {
        $dadosFormatados = array_map(function ($item) {
            return is_object($item) && method_exists($item, 'toArray')
                ? $item->toArray()
                : (array) $item;
        }, $dados);

        return $this->model->insert($dadosFormatados);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public function buscarTodos()
    {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @return TModel
     */
    public function buscarPorId(int $id, Array $with = [])
    {
        return $this->model
            ->with($with)
            ->findOrFail($id);
    }

    /**
     * @param int $id
     * @param TAtualizar $data
     * @return TModel
     */
    public function atualizar(int $id, object $data)
    {
        $entity = $this->model->findOrFail($id);
        $entity->update($data->toArrayUpdate());
        return $entity;
    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function deletar(int $id)
    {
        return $this->model->destroy($id);
    }
}
