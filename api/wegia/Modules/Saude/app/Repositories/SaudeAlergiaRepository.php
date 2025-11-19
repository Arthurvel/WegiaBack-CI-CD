<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeAlergiaBuscarTodosParamsDTO;
use Modules\Saude\app\Models\SaudeAlergia;

class SaudeAlergiaRepository extends BaseRepository
{

    public function __construct(
        SaudeAlergia $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosSemOsCadastrados(SaudeAlergiaBuscarTodosParamsDTO $dto)
    {
        $id_fichamedica = $dto->id_fichamedica ?? null;

        return $this->model
            ->when($id_fichamedica, function ($query) use ($id_fichamedica) {
                $query->whereDoesntHave('fichaMedica', function ($query) use ($id_fichamedica) {
                    $query->where('saude_fichamedica_alergia.id_fichamedica', $id_fichamedica);
                });
            })
            ->get();
    }
}
