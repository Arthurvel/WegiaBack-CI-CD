<?php

namespace app\Repositories\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoBuscarTodosDTO;
use app\Models\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacao;
use App\Repositories\Base\BaseRepository;

class AtendidoAceitacaoProcessoDeAceitacaoRepository extends BaseRepository
{

    public function __construct(
        AtendidoAceitacaoProcessoDeAceitacao $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(AtendidoAceitacaoBuscarTodosDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;
        $status          = $dto->status ?? null;

        return $this->model
            ->with(['pessoa', 'arquivos', 'status'])
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('pessoa', function ($query) use ($buscar) {
                    $query->where('nome', 'like', '%' . $buscar . '%')
                        ->orWhere('cpf', 'like', '%' . $buscar . '%');
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('id_status', $status);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarPorIdPessoa(int $idPessoa): ?AtendidoAceitacaoProcessoDeAceitacao
    {
        return $this->model
            ->where('id_pessoa', $idPessoa)
            ->first();
    }

}
