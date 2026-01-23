<?php

use App\Http\Controllers\Atendido\AtendidoController;
use App\Http\Controllers\Atendido\AtendidoOcorrenciaController;
use App\Http\Controllers\Atendido\AtendidoStatusController;
use App\Http\Controllers\Atendido\AtendidoTipoController;
use app\Http\Controllers\Atendido\Aceitacao\AtendidoAceitacaoPaStatusController;
use app\Http\Controllers\Atendido\Aceitacao\AtendidoAceitacaoProcessoDeAceitacaoController;
use app\Http\Controllers\Atendido\Aceitacao\AtendidoAceitacaoPaArquivoController;
use app\Http\Controllers\Atendido\Aceitacao\AtendidoAceitacaoPaEtapaController;
use app\Http\Controllers\Atendido\Aceitacao\AtendidoAceitacaoEtapaArquivoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvisoController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\Funcionario\FuncionarioController;
use App\Http\Controllers\Funcionario\FuncionarioDependenteController;
use App\Http\Controllers\Funcionario\FuncionarioDocumentoController;
use App\Http\Controllers\Funcionario\FuncionarioInfoController;
use App\Http\Controllers\Funcionario\FuncionarioQuadroHorarioController;
use App\Http\Controllers\Funcionario\FuncionarioRemuneracaoController;
use App\Http\Controllers\Funcionario\Perfil\FuncionarioPerfilController;
use App\Http\Controllers\Funcionario\Perfil\FuncionarioPermissaoController;
use app\Http\Controllers\Pessoa\PessoaController;
use App\Http\Controllers\Pessoa\PessoaDependenteController;
use app\Http\Controllers\Pessoa\PessoaTipoArquivoController;
use app\Http\Controllers\Pessoa\PessoaArquivoController;
use App\Http\Controllers\SituacaoController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Configuracao\SelecaoParagrafoController;
use app\Http\Controllers\Configuracao\ContatoInstituicaoController;
use app\Http\Controllers\Configuracao\EnderecoInstituicaoController;
use app\Http\Controllers\Configuracao\CampoImagemController;
use app\Http\Controllers\Configuracao\ImagemController;
use Illuminate\Support\Facades\Route;

Route::get('/upload/{path}', [UploadController::class, 'retornarImagem'])
    ->where('path', '.*')
    ->name('file.upload');

Route::group([ 'prefix' => 'auth' ], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([ 'prefix' => 'aviso' ], function () {
    Route::get('/', [AvisoController::class, 'index']);
    Route::get('/{id}', [AvisoController::class, 'buscarPorId']);
    Route::put('/{id}', [AvisoController::class, 'desativar']);
});

Route::group([ 'prefix' => 'pessoa' ], function () {
    Route::get('/logada', [PessoaController::class, 'retornarPessoaLogada']);
    Route::get('/filtro', [PessoaController::class, 'buscarPessoaParaFiltros']);
    Route::get('/{id_pessoa}/dependente', [PessoaDependenteController::class, 'buscarDependentesPorIdPessoa']);
    Route::get('/{cpf}', [PessoaController::class, 'buscarPessoaPorCpf']);

    Route::post('/', [PessoaController::class, 'create']);
    Route::post('/{id_pessoa}/imagem', [PessoaController::class, 'cadastrarOuAtualizarImagem']);
    Route::post('/{id_pessoa}/dependente/{id_dependente}', [PessoaDependenteController::class, 'create']);

    Route::get('/dependente/{id}', [PessoaDependenteController::class, 'buscarDependentePorId']);
    Route::delete('/dependente/{id_dependente}', [PessoaDependenteController::class, 'destroy']);

    Route::get('/{id}/arquivo', [PessoaArquivoController::class, 'index']);
    Route::post('/{id}/arquivo', [PessoaArquivoController::class, 'cadastrar']);


    Route::group([ 'prefix' => 'arquivo' ], function () {
        Route::get('/tipo', [PessoaTipoArquivoController::class, 'index']);
        Route::post('/tipo', [PessoaTipoArquivoController::class, 'cadastrar']);

        Route::delete('/{id}', [PessoaArquivoController::class, 'deletar']);
    });

    Route::put('/senha', [PessoaController::class, 'mudarPropriaSenha']);
    Route::put('{id}/senha', [PessoaController::class, 'mudarSenhaDeFuncionarios']);
    Route::put('/{id_pessoa}', [PessoaController::class, 'update']);
});

Route::group([ 'prefix' => 'funcionario' ], function () {
    Route::get('/', [FuncionarioController::class, 'index']);
    Route::get('/todos', [FuncionarioController::class, 'buscarTodos']);
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

    Route::group([ 'prefix' => 'aceitacao'], function () {

        Route::get('/', [AtendidoAceitacaoProcessoDeAceitacaoController::class, 'buscarTodos']);
        Route::post('/', [AtendidoAceitacaoProcessoDeAceitacaoController::class, 'cadastrar']);
        Route::put('/{id}', [AtendidoAceitacaoProcessoDeAceitacaoController::class, 'atualizar']);

        Route::post('/pessoa/{id_pessoa}', [AtendidoAceitacaoProcessoDeAceitacaoController::class, 'cadastrarComPessoa']);

        Route::post('/{id_processo}/arquivo', [AtendidoAceitacaoPaArquivoController::class, 'cadastrar']);

        Route::get('/{id_processo}/etapa', [AtendidoAceitacaoPaEtapaController::class, 'buscarTodos']);
        Route::post('/{id_processo}/etapa', [AtendidoAceitacaoPaEtapaController::class, 'cadastrar']);
        Route::put('/etapa/{id_etapa}', [AtendidoAceitacaoPaEtapaController::class, 'atualizar']);

        Route::post('/etapa/{id_etapa}/arquivo', [AtendidoAceitacaoEtapaArquivoController::class, 'cadastrar']);

        Route::get('/status', [AtendidoAceitacaoPaStatusController::class, 'index']);

        Route::get('/{id}', [AtendidoAceitacaoProcessoDeAceitacaoController::class, 'buscarPorId']);
    });


    Route::get('/{id}', [AtendidoController::class, 'atendidoPorId']);
});

// Configuracao

Route::group([ 'prefix' => 'configuracao'], function () {

    Route::group([ 'prefix' => 'selecao-paragrafo'], function () {
        Route::get('/', [SelecaoParagrafoController::class, 'index']);
        Route::put('/{id}', [SelecaoParagrafoController::class, 'atualizar']);
    });

    Route::group([ 'prefix' => 'contato-instituicao'], function () {
        Route::get('/', [ContatoInstituicaoController::class, 'index']);
        Route::post('/', [ContatoInstituicaoController::class, 'cadastrar']);
        Route::put('/{id}', [ContatoInstituicaoController::class, 'atualizar']);
        Route::delete('/{id}', [ContatoInstituicaoController::class, 'deletar']);
    });

    Route::group([ 'prefix' => 'endereco-instituicao'], function () {
        Route::get('/', [EnderecoInstituicaoController::class, 'index']);
        Route::put('/', [EnderecoInstituicaoController::class, 'atualizar']);
    });

    Route::group([ 'prefix' => 'campo-imagem'], function () {
        Route::get('/', [CampoImagemController::class, 'index']);
    });

    Route::group([ 'prefix' => 'imagem'], function () {
        Route::get('/', [ImagemController::class, 'index']);
        Route::post('/', [ImagemController::class, 'cadastrar']);
        Route::post('/campo-imagem/{id_campo_imagem}', [ImagemController::class, 'cadastrarImagemEmUmCampo']);
        Route::post('/{id_imagem}/campo-imagem/{id_campo_imagem}', [ImagemController::class, 'substituirImagemEmUmCampo']);
        Route::delete('/{id}', [ImagemController::class, 'deletar']);
    });
});
