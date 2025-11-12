<?php

namespace app\Repositories\Funcionario;

use app\DTOs\Funcionario\Documento\FuncionarioDocumentoBuscarDTO;
use app\DTOs\Funcionario\Documento\FuncionarioDocumentoTipoCadastrarDTO;
use App\Models\Funcionario\FuncionarioDocFuncional;
use App\Models\Funcionario\FuncionarioDocs;
use App\Repositories\Base\BaseRepository;

class FuncionarioDocumentoRepository extends BaseRepository
{

    private FuncionarioDocFuncional $funcionarioDocFuncional;

    public function __construct(
        FuncionarioDocs $model,
        FuncionarioDocFuncional $funcionarioDocFuncional
    )
    {
        parent::__construct($model);
        $this->funcionarioDocFuncional = $funcionarioDocFuncional;
    }

    public function pegarDocumentos(FuncionarioDocumentoBuscarDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $id_funcionario = $dto->id_funcionario ?? null;

        return $this->model
            ->with(['funcionarioDocFuncional'])
            ->when(!is_null($id_funcionario), function ($q) use ($id_funcionario) {

                return $q->where('id_funcionario', $id_funcionario);

            })
            ->when(!is_null($buscar), function ($q) use ($buscar) {

                return $q->where(function ($q2) use ($buscar) {
                    $q2->whereHas('funcionarioDocFuncional', function ($q3) use ($buscar) {
                        $q3->where('nome_docfuncional', 'like', "%{$buscar}%");
                    });
                })->orWhere('data', 'like', "%{$buscar}%");

            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'nome_docfuncional') {
                    return $q->join('funcionario_docfuncional', 'funcionario_docs.id_docfuncional', '=', 'funcionario_docfuncional.id_docfuncional')
                        ->orderBy("funcionario_docfuncional.nome_docfuncional", $tipoOrdenacao);
                }

                return $q->orderBy($ordenacao, $tipoOrdenacao);
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarDocumentoTipo()
    {
        return $this->funcionarioDocFuncional->get();
    }

    public function cadastrarDocumentoTipo(FuncionarioDocumentoTipoCadastrarDTO $dto)
    {
        return $this->funcionarioDocFuncional->create($dto->toArray());
    }
}
