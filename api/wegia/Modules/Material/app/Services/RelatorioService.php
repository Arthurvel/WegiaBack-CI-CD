<?php

namespace Modules\Material\app\Services;

use Modules\Material\app\DTO\RelatorioMaterialBuscarTodosParamsDTO;
use Modules\Material\app\DTO\RelatorioMaterialEstoqueBuscarTodosParamsDTO;
use Modules\Material\app\DTO\RelatorioMaterialProdutoBuscarTodosParamsDTO;
use Modules\Material\app\Repositories\RelatorioRepository;

class RelatorioService
{

    private RelatorioRepository $relatorioRepository;

    public function __construct(
        RelatorioRepository $relatorioRepository
    )
    {
        $this->relatorioRepository = $relatorioRepository;
    }

    public function obterRelatorioMaterial(RelatorioMaterialBuscarTodosParamsDTO $dto)
    {
        return $this->relatorioRepository->obterRelatorioMaterial($dto);
    }

    public function obterRelatorioEstoque(RelatorioMaterialEstoqueBuscarTodosParamsDTO $dto)
    {
        return $this->relatorioRepository->obterRelatorioEstoque($dto);
    }

    public function obterRelatorioProduto(RelatorioMaterialProdutoBuscarTodosParamsDTO $dto)
    {
        return $this->relatorioRepository->obterRelatorioProduto($dto);
    }

}
