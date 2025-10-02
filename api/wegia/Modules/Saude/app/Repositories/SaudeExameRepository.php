<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeExameBuscarParamsDTO;
use Modules\Saude\app\Models\SaudeExame;

class SaudeExameRepository extends BaseRepository
{

    public function __construct(
        SaudeExame $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(SaudeExameBuscarParamsDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $id_fichamedica = $dto->id_fichamedica;

        return $this->model
            ->with('tipo')
            ->where('id_fichamedica', $id_fichamedica)
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('tipo', function ($q2) use ($buscar) {
                    $q2->where('descricao', 'like', "%{$buscar}%");
                })->orWhere('arquivo_nome', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'descricao') {
                    return $q->join('saude_exame_tipos', 'saude_exames.id_exame_tipo', '=', 'saude_exame_tipos.id_exame_tipo')
                        ->orderBy("saude_exame_tipos.{$ordenacao}", $tipoOrdenacao);
                } else {
                    return $q->orderBy($ordenacao, $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

}
