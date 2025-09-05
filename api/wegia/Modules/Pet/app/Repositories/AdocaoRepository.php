<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\Models\Adocao;

class AdocaoRepository extends BaseRepository
{

    public function __construct(
        Adocao $model
    )
    {
        parent::__construct($model);
    }

    public function existePetAdotado(int $id_pet)
    {
        return $this->model
            ->where('id_pet', $id_pet)
            ->exists();
    }
}
