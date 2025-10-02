<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeIntercorrenciaBuscarTodosParamsDTO;
use Modules\Saude\app\Models\SaudeIntercorrencia;
use Modules\Saude\app\Models\SaudeMedicacao;

class SaudeIntercorrenciaRepository extends BaseRepository
{

    public function __construct(
        SaudeIntercorrencia $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(SaudeIntercorrenciaBuscarTodosParamsDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $id_ficha_medica = $dto->id_fichamedica;

        return $this->model
            ->where('id_fichamedica', $id_ficha_medica)
            ->with([
                'funcionario' => function($q) {
                    $q->select('id_funcionario', 'id_pessoa');
                    $q->with(['pessoa:id_pessoa,nome']);
                }
            ])
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy("{$ordenacao}", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
