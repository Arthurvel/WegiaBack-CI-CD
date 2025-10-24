<?php

use Illuminate\Support\Facades\Route;
use Modules\Material\app\Http\Controllers\AlmoxarifadoController;
use Modules\Material\app\Http\Controllers\ParceiroController;
use Modules\Material\app\Http\Controllers\TipoMovimentacaoController;
use Modules\Material\app\Http\Controllers\UnidadeController;
use Modules\Material\app\Http\Controllers\CategoriaController;
use Modules\Material\app\Http\Controllers\ProdutoController;
use Modules\Material\app\Http\Controllers\TransacaoController;

Route::prefix('material')->group(function () {

    Route::prefix('almoxarifado')->group(function () {
        Route::post('/', [AlmoxarifadoController::class, 'cadastrar']);
        Route::put('/{id}', [AlmoxarifadoController::class, 'atualizar']);
        Route::get('/', [AlmoxarifadoController::class, 'buscarTodosPaginados']);
        Route::get('/filtros', [AlmoxarifadoController::class, 'buscarTodos']);
    });

    Route::prefix('parceiro')->group(function () {
        Route::post('/', [ParceiroController::class, 'cadastrar']);
        Route::get('/filtros', [ParceiroController::class, 'buscarTodos']);
    });

    Route::prefix('tipo-movimentacao')->group(function () {
        Route::post('/', [TipoMovimentacaoController::class, 'cadastrar']);
        Route::get('/filtros', [TipoMovimentacaoController::class, 'buscarTodosFiltro']);
    });

    Route::prefix('unidade')->group(function () {
        Route::post('/', [UnidadeController::class, 'cadastrar']);
        Route::get('/filtros', [UnidadeController::class, 'buscarTodos']);
    });

    Route::prefix('categoria')->group(function () {
        Route::post('/', [CategoriaController::class, 'cadastrar']);
        Route::put('/{id}', [CategoriaController::class, 'atualizar']);
        Route::get('/', [CategoriaController::class, 'buscarTodosPaginado']);
        Route::get('/filtros', [CategoriaController::class, 'buscarTodos']);
    });

    Route::prefix('produto')->group(function () {
        Route::post('/', [ProdutoController::class, 'cadastrar']);
        Route::get('/', [ProdutoController::class, 'buscarTodos']);
        Route::get('/filtros', [ProdutoController::class, 'buscarTodosParaFiltro']);
        Route::put('/{id}', [ProdutoController::class, 'atualizar']);
    });

    Route::prefix('transacao')->group(function () {
        Route::post('/', [TransacaoController::class, 'cadastrar']);
        Route::get('/', [TransacaoController::class, 'buscarTodosPaginado']);
        Route::put('/{id}', [TransacaoController::class, 'atualizar']);
    });

});



