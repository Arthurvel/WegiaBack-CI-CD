<?php

namespace App\Services\Base;

/**
 * @template TCriar objeto de dto
 * @template TAtualizar objeto de dto
 */
abstract class BaseService
{
    protected $repository;

    /**
     * @param mixed $repository
     */
    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param TCriar $dto
     */
    public function criar(object $dto)
    {
        return $this->repository->criar($dto);
    }

    /**
     * @param TAtualizar $dto
     */
    public function atualizar(int $id, object $dto)
    {
        return $this->repository->atualizar($id, $dto);
    }

    public function buscarTodos()
    {
        return $this->repository->buscarTodos();
    }

    public function buscarPorId(int $id)
    {
        return $this->repository->buscarPorId($id);
    }

    public function deletar(int $id)
    {
        return $this->repository->deletar($id);
    }
}
