<?php

namespace Modules\Saude\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Saude\app\DTO\SaudeMedicacaoAdministracaoBuscarTodosParamDTO;
use Modules\Saude\app\Models\SaudeMedicamentoAdministracao;

class SaudeMedicamentoAdministracaoRepository extends BaseRepository
{
    public function __construct(
        SaudeMedicamentoAdministracao $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(SaudeMedicacaoAdministracaoBuscarTodosParamDTO $dto)
    {
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $id_medicacao = $dto->id_medicacao;

        return $this->model
            ->with([
                'funcionario' => function ($q) {
                    $q->select('id_funcionario', 'id_pessoa')
                        ->with(['pessoa' => function ($q2) {
                            $q2->select('id_pessoa', 'nome');
                        }]);
                }
            ])
            ->where('saude_medicacao_id_medicacao', $id_medicacao)
            ->orderBy('aplicacao', 'DESC')
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
