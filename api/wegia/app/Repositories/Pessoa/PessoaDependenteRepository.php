<?php

namespace app\Repositories\Pessoa;

use app\DTOs\Pessoa\Dependente\PessoaDependenteBuscarTodosPorIdDTO;
use App\Models\Pessoa\PessoaDependente;
use App\Repositories\Base\BaseRepository;

class PessoaDependenteRepository extends BaseRepository
{

    public function __construct(
        PessoaDependente $model
    )
    {
        parent::__construct($model);
    }

    public function buscarDependentesPorIdPessoa(int $id_pessoa, PessoaDependenteBuscarTodosPorIdDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $with           = isset($dto->with) ? explode(',', $dto->with) : [];

        return PessoaDependente::with($with)
            ->where('pessoa_dependente.id_pessoa', $id_pessoa)
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                return $q->whereHas('dependente', function ($q2) use ($buscar) {
                    $q2->where('nome', 'like', "%{$buscar}%");
                })->orWhere('parentesco', 'like', "%{$buscar}%");
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'nome') {
                    return $q->join('pessoa', 'pessoa_dependente.id_dependente_pessoa', '=', 'pessoa.id_pessoa')
                        ->orderBy("pessoa.{$ordenacao}", $tipoOrdenacao);
                }

                return $q->orderBy("pessoa_dependente.{$ordenacao}", $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function jaExisteRelacionamento(int $id_pessoa, int $id_dependente_pessoa)
    {
        return $this->model->where('id_pessoa', $id_pessoa)
            ->where('id_dependente_pessoa', $id_dependente_pessoa)
            ->exists();
    }

}
