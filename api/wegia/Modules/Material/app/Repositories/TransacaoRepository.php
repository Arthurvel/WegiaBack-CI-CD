<?php

namespace Modules\Material\app\Repositories;

use App\Repositories\Base\BaseRepository;
use Modules\Material\app\DTO\TransacaoBuscarTodosParamsDTO;
use Modules\Material\app\Models\Transacao;

class TransacaoRepository extends BaseRepository
{

    public function __construct(
        Transacao $model
    )
    {
        parent::__construct($model);
    }

    public function buscarTodosPaginado(TransacaoBuscarTodosParamsDTO $dto)
    {
        $buscar         = $dto->buscar ?? null;
        $ordenacao      = $dto->ordenacao ?? null;
        $tipoOrdenacao  = $dto->tipoOrdenacao ?? 'ASC';
        $itensPorPagina = $dto->itensPorPagina ?? 10;
        $pagina         = $dto->pagina ?? 1;
        $tipo           = $dto->tipo ?? null;

        return $this->model
            ->with([
                'parceiro',
                'tipoMovimentacao',
                'almoxarifado',
                'responsavel',
                'transacaoProduto.produto.unidade',
                'transacaoProduto.produto.categoria'
            ])
            ->when($tipo, function ($q) use ($tipo) {
                $q->whereHas('tipoMovimentacao', function ($sub) use ($tipo) {
                    $sub->where('tipo', $tipo);
                });
            })
            ->when($buscar, function ($q) use ($buscar) {
                $q->WhereHas('parceiro', function ($sub) use ($buscar) {
                        $sub->where('nome', 'like', "%{$buscar}%");
                    })
                    ->orWhereHas('tipoMovimentacao', function ($sub) use ($buscar) {
                        $sub->where('nome', 'like', "%{$buscar}%");
                    });
            })
            ->when($ordenacao, function ($q) use ($ordenacao, $tipoOrdenacao) {
                switch ($ordenacao) {

                    case 'descricao_almoxarifado':
                        $q->join('material_almoxarifado', 'material_transacao.id_almoxarifado', '=', 'material_almoxarifado.id_almoxarifado')
                            ->orderBy("material_almoxarifado.descricao", $tipoOrdenacao);
                        break;

                    case 'descricao_tipo_movimentacao':
                        $q->join('material_tipo_movimentacao', 'material_transacao.id_tipo_movimentacao', '=', 'material_tipo_movimentacao.id_tipo_movimentacao')
                            ->orderBy("material_tipo_movimentacao.nome", $tipoOrdenacao);
                        break;

                    case 'nome_parceiro':
                        $q->whereHas('parceiro', function ($sub) use ($tipoOrdenacao) {
                            $sub->orderBy('nome', $tipoOrdenacao);
                        });
                        break;

                    default:
                        $q->orderBy($ordenacao, $tipoOrdenacao);
                        break;
                }
            })
            ->paginate($itensPorPagina, ['*'], 'page', $pagina);
    }

    public function buscarTodosResponsaveisTransacionais()
    {
        return $this->model
            ->with(['responsavel:id_pessoa,nome'])
            ->get()
            ->pluck('responsavel')
            ->unique('id_pessoa')
            ->values();
    }
}
