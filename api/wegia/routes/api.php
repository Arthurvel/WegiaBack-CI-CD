<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AuthController;

Route::group([ 'prefix' => 'auth' ], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([ 'prefix' => 'pessoa' ], function () {
    Route::get('/logada', [PessoaController::class, 'retornarPessoaLogada']);
    Route::post('/', [PessoaController::class, 'create']);
});