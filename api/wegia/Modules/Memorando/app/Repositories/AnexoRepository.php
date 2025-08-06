<?php

namespace Modules\Memorando\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Memorando\app\Models\Anexo;

class AnexoRepository extends BaseRepository
{
    public function __construct(
        Anexo $model
    )
    {
        parent::__construct($model);
    }

}
