<?php

namespace app\Repositories\Funcionario;

use app\DTOs\Funcionario\Infos\FuncionarioInfosBuscarDTO;
use app\DTOs\Funcionario\Infos\FuncionarioListaInfoDTO;
use App\Models\Funcionario\FuncionarioListaInfo;
use App\Models\Funcionario\FuncionarioOutrasInfo;
use App\Repositories\Base\BaseRepository;

class FuncionarioInfoRepository extends BaseRepository
{

    private FuncionarioListaInfo $funcionarioListaInfo;

    public function __construct(
        FuncionarioOutrasInfo $model,
        FuncionarioListaInfo $funcionarioListaInfo
    )
    {
        parent::__construct($model);
        $this->funcionarioListaInfo = $funcionarioListaInfo;
    }

    public function buscarInfosPorIdFuncionario(FuncionarioInfosBuscarDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $id_funcionario = $dto->id_funcionario ?? null;

        return $this->model
            ->with(['listaInfo'])
            ->where('funcionario_id_funcionario', $id_funcionario)
            ->when(!is_null($buscar), function ($q) use ($buscar) {
                $q->where(function ($query) use ($buscar) {
                    $query->whereHas('listaInfo', function ($q2) use ($buscar) {
                        $q2->where('descricao', 'like', "%{$buscar}%");
                    })
                        ->orWhere('dado', 'like', "%{$buscar}%");
                });
            })
            ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {

                if($ordenacao == 'descricao') {
                    return $q->join(
                        'funcionario_listainfo',
                        'funcionario_outrasinfo.funcionario_listainfo_idfuncionario_listainfo',
                        '=',
                        'funcionario_listainfo.idfuncionario_listainfo'
                    )
                        ->orderBy("funcionario_listainfo.{$ordenacao}", $tipoOrdenacao);
                } else {
                    return $q->orderBy($ordenacao, $tipoOrdenacao);
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function pegarListaInfo()
    {
        return $this->funcionarioListaInfo->all();
    }

    public function cadastrarListaInfo(FuncionarioListaInfoDTO $dto)
    {
        return $this->funcionarioListaInfo->create($dto->toArray());
    }
}
