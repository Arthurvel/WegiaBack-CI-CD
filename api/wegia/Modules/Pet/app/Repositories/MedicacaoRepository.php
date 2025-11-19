<?php

namespace Modules\Pet\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Pet\app\Models\Medicacao;
class MedicacaoRepository extends BaseRepository
{
    public function __construct(
        Medicacao $model
    )
    {
        parent::__construct($model);
    }
}
