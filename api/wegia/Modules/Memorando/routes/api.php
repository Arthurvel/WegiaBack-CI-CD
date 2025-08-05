<?php

use Illuminate\Support\Facades\Route;
use Modules\Memorando\app\Http\Controllers\MemorandoController;
use Modules\Memorando\app\Http\Controllers\DespachoController;

Route::prefix('memorando')->group(function () {

    Route::get('/', [MemorandoController::class, 'index']);
    Route::get('/participados', [MemorandoController::class, 'memorandosParticipados']);
    Route::get('/{id}', [MemorandoController::class, 'buscarPorId']);
    Route::post('/', [MemorandoController::class, 'cadastrar']);
    Route::put('/{id}', [MemorandoController::class, 'atualizar']);

});

Route::prefix('despacho')->group(function () {

    Route::post('/memorando/{id}', [DespachoController::class, 'cadastrar']);

});
