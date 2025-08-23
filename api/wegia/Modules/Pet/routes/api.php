<?php

use Illuminate\Support\Facades\Route;
use Modules\Pet\app\Http\Controllers\PetController;
use Modules\Pet\app\Http\Controllers\RacaController;
use Modules\Pet\app\Http\Controllers\EspecieController;
use Modules\Pet\app\Http\Controllers\FichaMedicaController;
use Modules\Pet\app\Http\Controllers\MedicamentoController;
use Modules\Pet\app\Http\Controllers\AtendimentoController;
use Modules\Pet\app\Http\Controllers\AdocaoController;

Route::prefix('pet')->group(function () {

    Route::get('/', [PetController::class, 'index']);
    Route::get('/{id}', [PetController::class, 'buscarPorId']);
    Route::post('/', [PetController::class, 'cadastrar']);
    Route::post('/{id}', [PetController::class, 'atualizar']);
    Route::delete('/{id}', [PetController::class, 'excluir']);

    Route::post('{id_pet}/adocao', [AdocaoController::class, 'cadastrar']);
    Route::put('adocao/{id}', [AdocaoController::class, 'atualizar']);

    Route::prefix('ficha-medica')->group(function () {

        Route::get('/{id}/atendimento', [AtendimentoController::class, 'index']);
        Route::post('/{id}/atendimento', [AtendimentoController::class, 'cadastrar']);

    });

    Route::prefix('{id}/ficha-medica')->group(function () {
        Route::post('/', [FichaMedicaController::class, 'cadastrar']);
        Route::put('/', [FichaMedicaController::class, 'atualizar']);
    });
});

Route::prefix('medicamento')->group(function () {

    Route::get('/', [MedicamentoController::class, 'index']);
    Route::get('/filtro', [MedicamentoController::class, 'buscarTodosParaFiltro']);
    Route::get('/{id}', [MedicamentoController::class, 'buscarPorId']);
    Route::post('/', [MedicamentoController::class, 'cadastrar']);
    Route::Put('/{id}', [MedicamentoController::class, 'atualizar']);

});

Route::prefix('raca')->group(function () {

    Route::get('/', [RacaController::class, 'index']);
    Route::post('/', [RacaController::class, 'create']);

});

Route::prefix('especie')->group(function () {

    Route::get('/', [EspecieController::class, 'index']);
    Route::post('/', [EspecieController::class, 'create']);

});
