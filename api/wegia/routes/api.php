<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FuncionarioController;

Route::group([ 'prefix' => 'auth' ], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([ 'prefix' => 'pessoa' ], function () {
    Route::get('/logada', [PessoaController::class, 'retornarPessoaLogada']);
    Route::post('/', [PessoaController::class, 'create']);
    Route::put('/{id_pessoa}', [PessoaController::class, 'update']);
});

Route::group([ 'prefix' => 'funcionario' ], function () {
    Route::get('/', [FuncionarioController::class, 'index']);
    Route::post('/', [FuncionarioController::class, 'create']);

    Route::get('/{id_funcionario}/documento', [FuncionarioController::class, 'pegarDocumentosDeUmFuncionario']);
    Route::post('/{id_funcionario}/documento', [FuncionarioController::class, 'adicionarDocumento']);
    Route::delete('/documento/{id_documento}', [FuncionarioController::class, 'deletarDocumento']);
});