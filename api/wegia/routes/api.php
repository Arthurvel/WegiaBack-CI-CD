<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\Funcionario\FuncionarioController;
use App\Http\Controllers\Funcionario\FuncionarioDependenteController;
use App\Http\Controllers\Funcionario\FuncionarioDocumentoController;
use App\Http\Controllers\Funcionario\FuncionarioInfoController;
use App\Http\Controllers\Funcionario\FuncionarioQuadroHorarioController;
use App\Http\Controllers\Funcionario\FuncionarioRemuneracaoController;
use App\Http\Controllers\Pet\CorController;
use App\Http\Controllers\Pet\EspecieController;
use App\Http\Controllers\Pet\RacaController;
use App\Http\Controllers\SituacaoController;
use App\Http\Controllers\UploadController;
use App\Models\Especie;

Route::get('/upload/{path}', [UploadController::class, 'retornarImagem'])
    ->where('path', '.*')
    ->name('file.upload');

Route::group([ 'prefix' => 'auth' ], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([ 'prefix' => 'pessoa' ], function () {
    Route::get('/logada', [PessoaController::class, 'retornarPessoaLogada']);
    Route::get('/{cpf}', [PessoaController::class, 'buscarPessoaPorCpf']);
    Route::post('/', [PessoaController::class, 'create']);
    Route::post('/{id_pessoa}/imagem', [PessoaController::class, 'cadastrarOuAtualizarImagem']);
    Route::put('/{id_pessoa}', [PessoaController::class, 'update']);
});

Route::group([ 'prefix' => 'funcionario' ], function () {
    Route::get('/', [FuncionarioController::class, 'index']);
    Route::post('/', [FuncionarioController::class, 'create']);

    Route::get('/{id_funcionario}/documento', [FuncionarioDocumentoController::class, 'pegarDocumentosDeUmFuncionario']);
    Route::post('/{id_funcionario}/documento', [FuncionarioDocumentoController::class, 'adicionarDocumento']);
    Route::delete('/documento/{id_documento}', [FuncionarioDocumentoController::class, 'deletarDocumento']);

    Route::get('/documento/tipo', [FuncionarioDocumentoController::class, 'buscarDocumentoTipo']);
    Route::post('/documento/tipo', [FuncionarioDocumentoController::class, 'cadastrarDocumentoTipo']);

    Route::get('/{id_funcionario}/outra-info', [FuncionarioInfoController::class, 'buscarInfosPorIdFuncionario']);
    Route::post('/{id_funcionario}/outra-info/{id_funcionario_lista_info}', [FuncionarioInfoController::class, 'create']);
    Route::delete('/outra-info/{id_funcionario_outrasinfo}', [FuncionarioInfoController::class, 'destroy']);

    Route::group([ 'prefix' => 'lista-info' ], function () {
        Route::get('/', [FuncionarioInfoController::class, 'pegarListaInfo']);
        Route::post('/', [FuncionarioInfoController::class, 'cadastrarListaInfo']);
    });

    Route::get('/{id_funcionario}/remuneracao', [FuncionarioRemuneracaoController::class, 'buscarRemuneracaoPorFuncionario']);
    Route::get('/{id_funcionario}/remuneracao/total', [FuncionarioRemuneracaoController::class, 'buscarRemuneracaoTotalPorFuncionario']);

    Route::group([ 'prefix' => 'remuneracao' ], function () {
        Route::post('/', [FuncionarioRemuneracaoController::class, 'create']);
        Route::delete('/{id_remuneracao}', [FuncionarioRemuneracaoController::class, 'destroy']);

        Route::group([ 'prefix' => 'tipo' ], function () {
            Route::get('/', [FuncionarioRemuneracaoController::class, 'pegarRemuneracaoTipo']);
            Route::post('/', [FuncionarioRemuneracaoController::class, 'cadastrarRemuneracaoTipo']);
        });
    });

    Route::get('/{id_funcionario}/quadro-horario', [FuncionarioQuadroHorarioController::class, 'buscarQuadroHorarioPorFuncionario']);
    Route::post('/{id_funcionario}/quadro-horario', [FuncionarioQuadroHorarioController::class, 'create']);

    Route::group([ 'prefix' => 'quadro-horario' ], function () {

        Route::get('/escala', [FuncionarioQuadroHorarioController::class, 'buscarEscalaQuadroHorario']);
        Route::get('/tipo', [FuncionarioQuadroHorarioController::class, 'buscarTipoQuadroHorario']);
    });

    Route::get('/{id_funcionario}/dependente', [FuncionarioDependenteController::class, 'index']);
    Route::group([ 'prefix' => 'dependente' ], function () {
        Route::post('/', [FuncionarioDependenteController::class, 'create']);
        Route::delete('/{id_dependente}', [FuncionarioDependenteController::class, 'destroy']);

        Route::get('/tipo', [FuncionarioDependenteController::class, 'buscarDependenteParentesco']);
        Route::post('/tipo', [FuncionarioDependenteController::class, 'cadastrarDependenteParentesco']);
    });

    Route::get('/{id_funcionario}', [FuncionarioController::class, 'findById']);
    Route::put('/{id_funcionario}', [FuncionarioController::class, 'update']);
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
Route::group(['prefix' => 'pet'], function ( ){
    Route::group(['prefix' => 'especie'], function ( ){
        Route::post('/', [EspecieController::class, 'create']);
        Route::get('/', [EspecieController::class, 'index']);
    });
    Route::group(['prefix' => 'raca'], function ( ){
        Route::post('/', [RacaController::class, 'create']);
        Route::get('/', [RacaController::class, 'index']);
    });
});