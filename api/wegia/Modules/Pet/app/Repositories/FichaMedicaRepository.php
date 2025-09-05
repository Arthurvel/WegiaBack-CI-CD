<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\DTO\FichaMedicaAtualizarDTO;
use Modules\Pet\app\Models\FichaMedica;

class FichaMedicaRepository extends BaseRepository
{

    public function __construct(
        FichaMedica $model
    )
    {
        parent::__construct($model);
    }

    public function buscarPorPet(int $id)
    {
        return $this->model
            ->where('id_pet', $id)
            ->firstOrFail();
    }


    public function atualizarPorPet(int $id, FichaMedicaAtualizarDTO $dto)
    {
        $ficha = $this->buscarPorPet($id);

        return $ficha->update($dto->toArrayUpdate());
    }

}
