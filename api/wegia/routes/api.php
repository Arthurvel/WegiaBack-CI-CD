<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\Funcionario\FuncionarioController;
use App\Http\Controllers\Funcionario\FuncionarioDocumentoController;
use App\Http\Controllers\Funcionario\FuncionarioInfoController;
use App\Http\Controllers\SituacaoController;

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
    Route::put('/{id_funcionario}', [FuncionarioController::class, 'update']);

    Route::get('/{id_funcionario}/documento', [FuncionarioDocumentoController::class, 'pegarDocumentosDeUmFuncionario']);
    Route::post('/{id_funcionario}/documento', [FuncionarioDocumentoController::class, 'adicionarDocumento']);
    Route::delete('/documento/{id_documento}', [FuncionarioDocumentoController::class, 'deletarDocumento']);

    Route::get('/{id_funcionario}/outra-info', [FuncionarioInfoController::class, 'buscarInfosPorIdFuncionario']);
    Route::post('/{id_funcionario}/outra-info/{id_funcionario_lista_info}', [FuncionarioInfoController::class, 'create']);
    Route::delete('/outra-info/{id_funcionario_outrasinfo}', [FuncionarioInfoController::class, 'destroy']);

    Route::group([ 'prefix' => 'lista-info' ], function () {
        Route::get('/', [FuncionarioInfoController::class, 'pegarListaInfo']);
        Route::post('/', [FuncionarioInfoController::class, 'cadastrarListaInfo']);
    });
});

Route::group([ 'prefix' => 'situacao'], function () {
    Route::get('/', [SituacaoController::class, 'index']);
    Route::post('/', [SituacaoController::class, 'create']);
    Route::delete('/{id_situacao}', [SituacaoController::class, 'destroy']);
});

Route::group([ 'prefix' => 'cargo'], function () {
    Route::get('/', [CargoController::class, 'index']);
    Route::post('/', [CargoController::class, 'create']);
    Route::delete('/{id_cargo}', [CargoController::class, 'destroy']);
});