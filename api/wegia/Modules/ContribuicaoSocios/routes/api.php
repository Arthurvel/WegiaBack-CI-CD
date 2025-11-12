<?php

use Illuminate\Support\Facades\Route;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoGatewayPagamentoController;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoMeioDePagamentoController;

Route::prefix('contribuicao')->group(function () {

    Route::prefix('gateway')->group(function () {
        Route::get('', [ContribuicaoGatewayPagamentoController::class, 'buscarTodosPaginado']);
        Route::get('filtro', [ContribuicaoGatewayPagamentoController::class, 'buscarTodosParaFiltro']);
        Route::post('', [ContribuicaoGatewayPagamentoController::class, 'cadastrar']);
        Route::put('{id}', [ContribuicaoGatewayPagamentoController::class, 'atualizar']);
    });

    Route::prefix('meio-pagamento')->group(function () {
        Route::get('', [ContribuicaoMeioDePagamentoController::class, 'buscarTodosPaginado']);
        Route::get('filtro', [ContribuicaoMeioDePagamentoController::class, 'buscarTodosParaFiltro']);
        Route::post('', [ContribuicaoMeioDePagamentoController::class, 'cadastrar']);
        Route::put('{id}', [ContribuicaoMeioDePagamentoController::class, 'atualizar']);
    });

});
