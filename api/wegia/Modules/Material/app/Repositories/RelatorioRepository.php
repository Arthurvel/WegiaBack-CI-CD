<?php

namespace Modules\Material\app\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Material\app\DTO\RelatorioMaterialBuscarTodosParamsDTO;
use Modules\Material\app\DTO\RelatorioMaterialEstoqueBuscarTodosParamsDTO;
use Modules\Material\app\DTO\RelatorioMaterialProdutoBuscarTodosParamsDTO;
use Modules\Material\app\Models\Views\MaterialRelatorioView;

class RelatorioRepository
{

    private MaterialRelatorioView $materialRelatorioView;

    public function __construct(
        MaterialRelatorioView $materialRelatorioView
    )
    {
        $this->materialRelatorioView = $materialRelatorioView;
    }

    public function obterRelatorioMaterial(RelatorioMaterialBuscarTodosParamsDTO $dto)
    {
        $periodo_inicial = $dto->periodo_inicial ?? null;
        $periodo_final = $dto->periodo_final ?? null;
        $id_tipo_movimentacao = $dto->id_tipo_movimentacao ?? null;
        $tipo_movimentacao = $dto->tipo_movimentacao ?? null;
        $id_parceiro        = $dto->id_parceiro ?? null;
        $id_responsavel =$dto->id_responsavel ?? null;
        $id_almoxarifado = $dto->id_almoxarifado ?? null;

        return $this->materialRelatorioView
            ->select(
                'id_transacao',
                'id_tipo_movimentacao',
                'id_parceiro',
                'id_responsavel',
                'id_almoxarifado',
                'tipo_movimentacao',
                'tipo',
                'almoxarifado',
                'id_produto',
                'produto',
                'unidade',
                'parceiro',
                'responsavel',
                'data',
                'valor_unitario',
                DB::raw('DATE(data) AS data'),
                DB::raw('SUM(quantidade) AS quantidade_total'),
                DB::raw('SUM(total) AS valor_total')
            )
            ->when($periodo_inicial, fn($q) =>
                $q->whereDate('data', '>=', $periodo_inicial)
            )
            ->when($periodo_final, fn($q) =>
                $q->whereDate('data', '<=', $periodo_final)
            )
            ->when($id_tipo_movimentacao, fn($q) =>
                $q->where('id_tipo_movimentacao', $id_tipo_movimentacao)
            )
            ->when($tipo_movimentacao, fn($q) =>
                $q->where('tipo', $tipo_movimentacao)
            )
            ->when($id_parceiro, fn($q) =>
                $q->where('id_parceiro', $id_parceiro)
            )
            ->when($id_responsavel, fn($q) =>
                $q->where('id_responsavel', $id_responsavel)
            )
            ->when($id_almoxarifado, fn($q) =>
                $q->where('id_almoxarifado', $id_almoxarifado)
            )
            ->groupBy(
                'id_produto',
                DB::raw('DATE(data)')
            )
            ->orderBy('data')
            ->get();
    }

    public function obterRelatorioEstoque(RelatorioMaterialEstoqueBuscarTodosParamsDTO $dto)
    {
        $id_almoxarifado = $dto->id_almoxarifado ?? null;

        return $this->materialRelatorioView
            ->select(
                'id_transacao',
                'id_almoxarifado',
                'id_produto',
                'produto',
                'unidade',
                DB::raw('
                    SUM(CASE WHEN tipo = "e" THEN quantidade ELSE 0 END) AS quantidade_entradas,
                    SUM(CASE WHEN tipo = "s" THEN quantidade ELSE 0 END) AS quantidade_saidas,
                    SUM(CASE WHEN tipo = "e" THEN total ELSE 0 END) AS total,
                    SUM(CASE WHEN tipo = "e" THEN quantidade ELSE 0 END) -
                    SUM(CASE WHEN tipo = "s" THEN quantidade ELSE 0 END) AS quantidade_estoque,
                    CASE
                        WHEN SUM(CASE WHEN tipo = "e" THEN quantidade ELSE 0 END) = 0 THEN 0
                        ELSE SUM(CASE WHEN tipo = "e" THEN total ELSE 0 END) /
                             SUM(CASE WHEN tipo = "e" THEN quantidade ELSE 0 END)
                    END AS preco_medio
                ')
            )
            ->when($id_almoxarifado, fn($q) =>
                $q->where('id_almoxarifado', $id_almoxarifado)
            )
            ->groupBy('id_almoxarifado', 'id_produto')
            ->get();
    }

    public function obterRelatorioProduto(RelatorioMaterialProdutoBuscarTodosParamsDTO $dto)
    {
        $periodo_inicial = $dto->periodo_inicial ?? null;
        $periodo_final   = $dto->periodo_final ?? null;
        $id_almoxarifado = $dto->id_almoxarifado ?? null;
        $id_produto      = $dto->produto ?? null;

        return $this->materialRelatorioView
            ->when($periodo_inicial, fn($q) =>
                $q->whereDate('data', '>=', $periodo_inicial)
            )
            ->when($periodo_final, fn($q) =>
                $q->whereDate('data', '<=', $periodo_final)
            )
            ->when($id_almoxarifado, fn($q) =>
                $q->where('id_almoxarifado', $id_almoxarifado)
            )
            ->when($id_produto, fn($q) =>
                $q->where('id_produto', $id_produto)
            )
            ->orderBy('data')
            ->get();
    }
}
