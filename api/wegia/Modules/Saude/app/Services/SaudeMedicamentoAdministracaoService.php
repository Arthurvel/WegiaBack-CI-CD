<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeMedicacaoAdministracaoBuscarTodosParamDTO;
use Modules\Saude\app\Repositories\SaudeMedicamentoAdministracaoRepository;

class SaudeMedicamentoAdministracaoService extends BaseService
{
    public function __construct
    (
        SaudeMedicamentoAdministracaoRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(SaudeMedicacaoAdministracaoBuscarTodosParamDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }
}
