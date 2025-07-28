<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Atendido\AtendidoController;
use App\Http\Controllers\Atendido\AtendidoOcorrenciaController;
use App\Http\Controllers\Atendido\AtendidoStatusController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\Funcionario\FuncionarioController;
use App\Http\Controllers\Funcionario\FuncionarioDependenteController;
use App\Http\Controllers\Funcionario\FuncionarioDocumentoController;
use App\Http\Controllers\Funcionario\FuncionarioInfoController;
use App\Http\Controllers\Funcionario\FuncionarioQuadroHorarioController;
use App\Http\Controllers\Funcionario\FuncionarioRemuneracaoController;
use App\Http\Controllers\Funcionario\Perfil\FuncionarioPerfilController;
use App\Http\Controllers\Funcionario\Perfil\FuncionarioPermissaoController;
use App\Http\Controllers\Pet\AtendimentoController;
use App\Http\Controllers\Pet\FichaMedicaController;
use App\Http\Controllers\Pet\MedicacaoController;
use App\Http\Controllers\Pet\MedicamentoController;
use App\Http\Controllers\Pet\CorController;
use App\Http\Controllers\Pet\EspecieController;
use App\Http\Controllers\Pet\RacaController;
use App\Http\Controllers\SituacaoController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Atendido\AtendidoTipoController;
use App\Http\Controllers\Pessoa\PessoaDependenteController;

Route::get('/upload/{path}', [UploadController::class, 'retornarImagem'])
    ->where('path', '.*')
    ->name('file.upload');

Route::group([ 'prefix' => 'auth' ], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([ 'prefix' => 'pessoa' ], function () {
    Route::get('/logada', [PessoaController::class, 'retornarPessoaLogada']);
    Route::get('/{id_pessoa}/dependente', [PessoaDependenteController::class, 'buscarDependentesPorIdPessoa']);
    Route::get('/{cpf}', [PessoaController::class, 'buscarPessoaPorCpf']);

    Route::post('/', [PessoaController::class, 'create']);
    Route::post('/{id_pessoa}/imagem', [PessoaController::class, 'cadastrarOuAtualizarImagem']);
    Route::post('/{id_pessoa}/dependente/{id_dependente}', [PessoaDependenteController::class, 'create']);

    Route::put('/{id_pessoa}', [PessoaController::class, 'update']);

    Route::delete('/dependente/{id_dependente}', [PessoaDependenteController::class, 'destroy']);
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

    Route::group([ 'prefix' => 'perfil' ], function () {
        Route::get('/', [FuncionarioPerfilController::class, 'buscarPerfis']);
        Route::get('/{id}/permissao', [FuncionarioPerfilController::class, 'buscarPermissoesDoPerfil']);
        Route::post('/', [FuncionarioPerfilController::class, 'cadastrarPerfil']);
        Route::post('/{id}/permissao', [FuncionarioPerfilController::class, 'cadastrarPermissao']);
        Route::put('/{id}', [FuncionarioPerfilController::class, 'atualizarPerfil']);
    });

    Route::group([ 'prefix' => 'permissao' ], function () {
        Route::get('/', [FuncionarioPermissaoController::class, 'buscarPermissao']);
    });

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

// Atendido

Route::group([ 'prefix' => 'atendido'], function () {
    Route::get('/', [AtendidoController::class, 'index']);
    Route::post('/', [AtendidoController::class, 'create']);

    Route::get('/tipo', [AtendidoTipoController::class, 'index']);
    Route::get('/status', [AtendidoStatusController::class, 'index']);

    Route::post('/{id}/ocorrencia', [AtendidoOcorrenciaController::class, 'criarOcorrencia']);

    Route::group([ 'prefix' => '{id}/ocorrencia'], function () {
        Route::get('/', [AtendidoOcorrenciaController::class, 'index']);
        Route::post('/', [AtendidoOcorrenciaController::class, 'criarOcorrencia']);
    });

    Route::group([ 'prefix' => 'ocorrencia'], function () {
        Route::get('/tipos', [AtendidoOcorrenciaController::class, 'buscarOcorrenciaTipos']);
    });

    Route::get('/{id}', [AtendidoController::class, 'atendidoPorId']);
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
    Route::post('/{id_pet}/ficha-medica', [FichaMedicaController::class, 'create']);
    Route::get('/{id_pet}/ficha-medica', [FichaMedicaController::class, 'index']);

    Route::group(['prefix' => 'ficha-medica'], function ( ){
        Route::put('/{id_ficha_medica}', [FichaMedicaController::class, 'update']);
        Route::post('/{id_ficha_medica}/atendimento', [AtendimentoController::class, 'create']);
        Route::delete('/atendimento/{id_atendimento}', [AtendimentoController::class, 'delete']);
        Route::put('/atendimento/{id_atendimento}', [AtendimentoController::class, 'update']);
        Route::get('/{id_ficha_medica}/atendimento', [AtendimentoController::class, 'index']);
        Route::post('/atendimento/{id_pet_atendimento}/medicacao', [MedicacaoController::class, 'create']);
        Route::delete('/atendimento/medicacao/{id_medicacao}', [MedicacaoController::class, 'delete']);
        Route::get('/atendimento/{id_pet_atendimento}/medicacao', [MedicacaoController::class, 'index']);
        Route::post('/atendimento/medicacao/medicamento', [MedicamentoController::class, 'create']);
        Route::delete('/atendimento/medicacao/medicamento/{id_medicamento}', [MedicamentoController::class, 'delete']);
        Route::get('/atendimento/medicacao/medicamento', [MedicamentoController::class, 'index']);
    });
});