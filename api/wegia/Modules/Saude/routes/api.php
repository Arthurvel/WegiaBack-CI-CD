<?php

use Illuminate\Support\Facades\Route;
use Modules\Saude\app\Http\Controllers\SaudeFichaMedicaController;
use Modules\Saude\app\Http\Controllers\SaudeFichaMedicaProntuarioHistoricoController;
use Modules\Saude\app\Http\Controllers\SaudeCIDController;
use Modules\Saude\app\Http\Controllers\SaudeEnfermidadesController;
use Modules\Saude\app\Http\Controllers\SaudeExameTiposController;
use Modules\Saude\app\Http\Controllers\SaudeExameController;

Route::prefix('saude')->group(function () {

    Route::prefix('ficha-medica')->group(function () {

        Route::post('/', [SaudeFichaMedicaController::class, 'cadastrar']);
        Route::get('/', [SaudeFichaMedicaController::class, 'buscarTodasFichasMedicas']);
        Route::put('/{id}', [SaudeFichaMedicaController::class, 'atualizarFichaMedica']);

        Route::post('/{id}/historico', [SaudeFichaMedicaProntuarioHistoricoController::class, 'cadastar']);

        Route::get('/{id}/enfermidade', [SaudeEnfermidadesController::class, 'buscarTodos']);
        Route::post('/{id}/enfermidade', [SaudeEnfermidadesController::class, 'cadastrar']);
        Route::put('/enfermidade/{id}', [SaudeEnfermidadesController::class, 'atualizar']);

        Route::post('/{id}/exame', [SaudeExameController::class, 'cadastrar']);
        Route::get('/{id}/exame', [SaudeExameController::class, 'buscarTodos']);

        Route::get('/{id}', [SaudeFichaMedicaController::class, 'buscarPorId']);
    });

    Route::prefix('exame')->group(function () {
        Route::delete('/{id}', [SaudeExameController::class, 'deletar']);
    });

    Route::prefix('exame-tipo')->group(function () {
        Route::get('/', [SaudeExameTiposController::class, 'buscarTodos']);
        Route::post('/', [SaudeExameTiposController::class, 'cadastrar']);
    });

    Route::prefix('cid')->group(function () {
        Route::get('/', [SaudeCIDController::class, 'buscarTodos']);
        Route::post('/', [SaudeCIDController::class, 'cadastrar']);
    });
});
