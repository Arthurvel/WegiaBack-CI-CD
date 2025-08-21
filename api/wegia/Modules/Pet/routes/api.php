<?php

use Illuminate\Support\Facades\Route;
use Modules\Pet\app\Http\Controllers\PetController;
use Modules\Pet\app\Http\Controllers\RacaController;
use Modules\Pet\app\Http\Controllers\EspecieController;

Route::prefix('pet')->group(function () {

    Route::get('/', [PetController::class, 'index']);
    Route::get('/{id}', [PetController::class, 'buscarPorId']);
    Route::post('/', [PetController::class, 'cadastrar']);
    Route::post('/{id}', [PetController::class, 'atualizar']);
    Route::delete('/{id}', [PetController::class, 'excluir']);

});


Route::prefix('raca')->group(function () {

    Route::get('/', [RacaController::class, 'index']);
    Route::post('/', [RacaController::class, 'create']);

});

Route::prefix('especie')->group(function () {

    Route::get('/', [EspecieController::class, 'index']);
    Route::post('/', [EspecieController::class, 'create']);

});
