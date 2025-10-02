<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeAtendimentoBuscarTodosParamsDTO;
use Modules\Saude\app\Models\SaudeAtendimento;

class SaudeAtendimentoRepository extends BaseRepository
{

    public function __construct(
        SaudeAtendimento $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(SaudeAtendimentoBuscarTodosParamsDTO $dto)
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
                'medicacoes',
                'medico',
                'funcionario' => function($q) {
                    $q->select('id_funcionario', 'id_pessoa');
                    $q->with(['pessoa:id_pessoa,nome']);
                }
            ])
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('medico', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                if($ordenacao == 'nome') {
                    return $q->join('saude_medicos', 'saude_atendimento.id_medico', '=', 'saude_medicos.id_medico')
                        ->orderBy("saude_medicos.{$ordenacao}", $tipoOrdenacao);
                }
                return $q->orderBy("{$ordenacao}", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

}
