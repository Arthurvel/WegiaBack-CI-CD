<?php

namespace Modules\ContribuicaoSocios\app\Repositories;
use App\DTOs\PaginacaoFiltrosDTO;
use App\Repositories\Base\BaseRepository;
use Modules\ContribuicaoSocios\app\Models\ContribuicaoMeioDePagamento;


class ContribuicaoMeioDePagamentoRepository extends BaseRepository
{

    public function __construct(
        ContribuicaoMeioDePagamento $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodos()
    {
        return $this->model->with(['gateway'])->get();
    }

    public function buscarTodosPaginado(PaginacaoFiltrosDTO $dto)
    {
        $buscar          = $dto->buscar ?? null;
        $ordenacao       = $dto->ordenacao ?? null;
        $tipoOrdenacao   = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina  = $dto->itensPorPagina ?? 10;
        $pagina          = $dto->pagina ?? 1;

        return $this->model
            ->with(['gateway'])
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->where('meio', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy("$ordenacao", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }
}
