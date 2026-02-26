<?php

namespace app\Repositories\Atendido;

use app\DTOs\Atendido\AtendidoBuscarDTO;
use App\Models\Atendido\Atendido;
use App\Repositories\Base\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AtendidoRepository extends BaseRepository
{

    public function __construct(
        Atendido $model
    )
    {
        parent::__construct($model);
    }

    public function buscarAtendidoPorCPF(string $cpf): ?Atendido
    {
        return $this->model
            ->with(['pessoa'])
            ->whereHas('pessoa', function ($query) use ($cpf) {
                $query->where('cpf', $cpf);
            })
            ->first();
    }

    public function buscarPorIdPessoa(int $idPessoa): ?Atendido
    {
        return $this->model
            ->where('pessoa_id_pessoa', $idPessoa)
            ->first();
    }

    public function buscarAtendimentos(AtendidoBuscarDTO $dto) : LengthAwarePaginator
    {
        $status         = $dto->id_status ?? null;
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $with           = isset($dto->with) ? explode(',', $dto->with) : [];

        return $this->model
            ->with($with)
            ->when(!is_null($status), function ($q) use ($status){
                return $q->where('atendido_status_idatendido_status', $status);
            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('pessoa', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%")
                        ->orWhere('cpf', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'nome' || $ordenacao == 'cpf') {
                    return $q->join('pessoa', 'atendido.pessoa_id_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy("pessoa.{$ordenacao}", $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

}
