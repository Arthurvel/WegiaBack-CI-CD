<?php

namespace Modules\Saude\app\Services;

use App\Services\Base\BaseService;
use Modules\Saude\app\DTO\SaudeMedicacaoBuscarTodosParamsDTO;
use Modules\Saude\app\Repositories\SaudeMedicacaoRepository;

class SaudeMedicacaoService extends BaseService
{

    public function __construct
    (
        SaudeMedicacaoRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(SaudeMedicacaoBuscarTodosParamsDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

}
