<?php

namespace app\Services\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaBuscarTodosDTO;
use app\Repositories\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaRepository;
use App\Services\Base\BaseService;

class AtendidoAceitacaoPaEtapaService extends BaseService
{

    public function __construct(
        AtendidoAceitacaoPaEtapaRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function buscarTodosPaginado(AtendidoAceitacaoPaEtapaBuscarTodosDTO $dto)
    {
        return $this->repository->buscarTodosPaginado($dto);
    }

}
