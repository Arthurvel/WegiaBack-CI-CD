<?php

namespace app\Repositories\Pessoa;

use app\DTOs\Pessoa\Arquivo\PessoaArquivoBuscarPaginadoDTO;
use app\Models\Pessoa\PessoaArquivo;
use App\Repositories\Base\BaseRepository;

class PessoaArquivoRepository extends BaseRepository
{

    public function __construct(
        PessoaArquivo $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginados(PessoaArquivoBuscarPaginadoDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $id_pessoa      = $dto->id_pessoa;

        return $this->model
            ->with(['tipoArquivo'])
            ->where('id_pessoa', $id_pessoa)
            ->when(!is_null($buscar), function ($q) use ($buscar) {

                return $q->where(function ($q2) use ($buscar) {
                    $q2->whereHas('tipoArquivo', function ($q3) use ($buscar) {
                        $q3->where('descricao', 'like', "%{$buscar}%");
                    })
                    ->orWhere('data', 'like', "%{$buscar}%");
                });

            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'descricao') {
                    return $q->join('pessoa_tipo_arquivo', 'pessoa_arquivo.id_pessoa_tipo_arquivo', '=', 'pessoa_tipo_arquivo.id_pessoa_tipo_arquivo')
                        ->orderBy("pessoa_tipo_arquivo.descricao", $tipoOrdenacao);
                }

                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

}
