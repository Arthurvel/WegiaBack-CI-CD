<?php

use Illuminate\Support\Facades\Route;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoGatewayPagamentoController;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoMeioDePagamentoController;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoRegrasController;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoConjuntoRegrasController;

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

    Route::prefix('regra')->group(function () {
        Route::get('filtro', [ContribuicaoRegrasController::class, 'buscarTodosParaFiltro']);

        Route::prefix('meio-pagamento')->group(function () {
            Route::get('', [ContribuicaoConjuntoRegrasController::class, 'buscarTodosPaginado']);
            Route::get('filtro', [ContribuicaoConjuntoRegrasController::class, 'buscarTodosParaFiltro']);
            Route::post('', [ContribuicaoConjuntoRegrasController::class, 'cadastrar']);
            Route::put('{id}', [ContribuicaoConjuntoRegrasController::class, 'atualizar']);
        });
    });

});
