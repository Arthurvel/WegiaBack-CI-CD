<?php

use Illuminate\Support\Facades\Route;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoGatewayPagamentoController;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoMeioDePagamentoController;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoRegrasController;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoConjuntoRegrasController;
use Modules\ContribuicaoSocios\app\Http\Controllers\SocioStatusController;
use Modules\ContribuicaoSocios\app\Http\Controllers\SocioTipoController;
use Modules\ContribuicaoSocios\app\Http\Controllers\SocioTagController;
use Modules\ContribuicaoSocios\app\Http\Controllers\SocioController;
use Modules\ContribuicaoSocios\app\Http\Controllers\PagamentoController;
use Modules\ContribuicaoSocios\app\Http\Controllers\ContribuicaoLogController;

Route::prefix('contribuicao')->group(function () {

    Route::get('', [ContribuicaoLogController::class, 'buscarTodasPaginado']);

    Route::post('pagamento', [PagamentoController::class, 'criarPagamento']);

    Route::prefix('gateway')->group(function () {
        Route::get('', [ContribuicaoGatewayPagamentoController::class, 'buscarTodosPaginado']);
        Route::get('filtro', [ContribuicaoGatewayPagamentoController::class, 'buscarTodosParaFiltro']);
        Route::post('', [ContribuicaoGatewayPagamentoController::class, 'cadastrar']);
        Route::put('{id}', [ContribuicaoGatewayPagamentoController::class, 'atualizar']);
    });

    Route::prefix('meio-pagamento')->group(function () {
        Route::get('', [ContribuicaoMeioDePagamentoController::class, 'buscarTodosPaginado']);
        Route::get('filtro', [ContribuicaoMeioDePagamentoController::class, 'buscarTodosParaFiltro']);
        Route::get('ativos', [ContribuicaoMeioDePagamentoController::class, 'buscarMeioPagamentosAtivos']);
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

Route::prefix('socio')->group(function () {

    Route::get('', [SocioController::class, 'buscarTodosPaginado']);
    Route::get('aniversariante', [SocioController::class, 'buscarTodosAniversariantesMesPaginado']);
    Route::get('relatorio', [SocioController::class, 'buscarSocioRelatorio']);
    Route::get('pessoa/{cpfCnpj}', [SocioController::class, 'buscarSocioPorCpf']);
    Route::post('', [SocioController::class, 'cadastrar']);
    Route::post('pessoa', [SocioController::class, 'cadastrarSocioPessoa']);
    Route::put('{id_socio}/pessoa/{id_pessoa}', [SocioController::class, 'atualizarComPessoa']);

    Route::prefix('status')->group(function () {
        Route::get('filtro', [SocioStatusController::class, 'buscarTodosParaFiltro']);
    });

    Route::prefix('tipo')->group(function () {
        Route::get('filtro', [SocioTipoController::class, 'buscarTodosParaFiltro']);
    });

    Route::prefix('tag')->group(function () {
        Route::get('filtro', [SocioTagController::class, 'buscarTodosParaFiltro']);
        Route::get('', [SocioTagController::class, 'buscarTodosPaginado']);
        Route::post('', [SocioTagController::class, 'cadastrar']);
        Route::put('{id}', [SocioTagController::class, 'atualizar']);
    });

});
