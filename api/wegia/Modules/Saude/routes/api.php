<?php

use Illuminate\Support\Facades\Route;
use Modules\Saude\app\Http\Controllers\SaudeFichaMedicaController;
use Modules\Saude\app\Http\Controllers\SaudeFichaMedicaProntuarioHistoricoController;
use Modules\Saude\app\Http\Controllers\SaudeCIDController;
use Modules\Saude\app\Http\Controllers\SaudeEnfermidadesController;
use Modules\Saude\app\Http\Controllers\SaudeExameTiposController;
use Modules\Saude\app\Http\Controllers\SaudeExameController;
use Modules\Saude\app\Http\Controllers\SaudeMedicoController;
use Modules\Saude\app\Http\Controllers\SaudeAtendimentoController;
use Modules\Saude\app\Http\Controllers\SaudeMedicacaoController;
use Modules\Saude\app\Http\Controllers\SaudeMedicamentoAdministracaoController;
use Modules\Saude\app\Http\Controllers\SaudeSinaisVitaisController;
use Modules\Saude\app\Http\Controllers\SaudeIntercorrenciaController;
use Modules\Saude\app\Http\Controllers\SaudeAlergiaController;
use Modules\Saude\app\Http\Controllers\SaudeFichaMedicaAlergiaController;

Route::prefix('saude')->group(function () {

    Route::prefix('ficha-medica')->group(function () {

        Route::post('/', [SaudeFichaMedicaController::class, 'cadastrar']);
        Route::get('/', [SaudeFichaMedicaController::class, 'buscarTodasFichasMedicas']);
        Route::put('/{id}', [SaudeFichaMedicaController::class, 'atualizarFichaMedica']);

        Route::post('/{id}/historico', [SaudeFichaMedicaProntuarioHistoricoController::class, 'cadastar']);

        Route::get('/{id}/enfermidade', [SaudeEnfermidadesController::class, 'buscarTodos']);
        Route::post('/{id}/enfermidade', [SaudeEnfermidadesController::class, 'cadastrar']);
        Route::put('/enfermidade/{id}', [SaudeEnfermidadesController::class, 'atualizar']);

        Route::get('/{id}/atendimento', [SaudeAtendimentoController::class, 'buscar']);
        Route::post('/{id}/atendimento', [SaudeAtendimentoController::class, 'cadastrarComMedicacao']);

        Route::get('/{id}/medicacao', [SaudeMedicacaoController::class, 'buscar']);

        Route::post('/{id}/exame', [SaudeExameController::class, 'cadastrar']);
        Route::get('/{id}/exame', [SaudeExameController::class, 'buscarTodos']);

        Route::post('/{id}/sinal-vital', [SaudeSinaisVitaisController::class, 'cadastrar']);
        Route::get('/{id}/sinal-vital', [SaudeSinaisVitaisController::class, 'buscarTodos']);

        Route::post('/{id}/intercorrencia', [SaudeIntercorrenciaController::class, 'cadastrar']);
        Route::get('/{id}/intercorrencia', [SaudeIntercorrenciaController::class, 'buscarTodos']);

        Route::post('/{id_fichamedica}/alergia/{id_alergia}', [SaudeFichaMedicaAlergiaController::class, 'cadastrar']);
        Route::get('/{id}/alergia', [SaudeFichaMedicaAlergiaController::class, 'buscarTodosPaginado']);
        Route::delete('/alergia/{id}', [SaudeFichaMedicaAlergiaController::class, 'deletar']);

        Route::get('/{id}', [SaudeFichaMedicaController::class, 'buscarPorId']);
    });

    Route::put('/medicacao/{id}', [SaudeMedicacaoController::class, 'atualizar']);
    Route::get('/medicacao/{id}/aplicacao', [SaudeMedicamentoAdministracaoController::class, 'buscarTodosPaginado']);
    Route::post('/medicacao/{id}/aplicacao', [SaudeMedicamentoAdministracaoController::class, 'cadastrar']);

    Route::prefix('exame')->group(function () {
        Route::delete('/{id}', [SaudeExameController::class, 'deletar']);
    });

    Route::prefix('exame-tipo')->group(function () {
        Route::get('/', [SaudeExameTiposController::class, 'buscarTodos']);
        Route::post('/', [SaudeExameTiposController::class, 'cadastrar']);
    });

    Route::prefix('medico')->group(function () {
        Route::get('/', [SaudeMedicoController::class, 'buscarTodos']);
        Route::post('/', [SaudeMedicoController::class, 'cadastrar']);
    });

    Route::prefix('alergia')->group(function () {
        Route::get('/', [SaudeAlergiaController::class, 'buscarTodos']);
        Route::post('/', [SaudeAlergiaController::class, 'cadastrar']);
    });

    Route::prefix('cid')->group(function () {
        Route::get('/', [SaudeCIDController::class, 'buscarTodos']);
        Route::post('/', [SaudeCIDController::class, 'cadastrar']);
    });
});
