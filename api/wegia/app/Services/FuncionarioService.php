<?php

namespace App\Services;

use App\DTOs\Funcionario\AtualizarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDependenteFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDocumentoDTO;
use App\DTOs\Funcionario\CadastrarDocumentoTipoDTO;
use App\DTOs\Funcionario\CadastrarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarQuadroHorarioDTO;
use App\DTOs\Funcionario\CadastrarRemuneracaoDTO;
use App\DTOs\Funcionario\FuncionarioDependenteDTO;
use App\DTOs\Funcionario\FuncionarioDocumentoDTO;
use App\DTOs\Funcionario\FuncionarioDTO;
use App\DTOs\Funcionario\FuncionarioOutrasInfoDTO;
use App\DTOs\Funcionario\FuncionarioQuadroHorarioDTO;
use App\DTOs\Funcionario\FuncionarioRemuneracaoDTO;
use App\DTOs\PaginacaoDTO;
use App\DTOs\Pessoa\PessoaCadastrarDTO;
use App\Helpers\UploadSeguroHelper;
use App\Models\Funcionario\Funcionario;
use App\Models\Funcionario\FuncionarioDependente;
use App\Models\Funcionario\FuncionarioDependenteParentesco;
use App\Models\Funcionario\FuncionarioDocs;
use App\Models\Funcionario\FuncionarioListaInfo;
use App\Models\Funcionario\FuncionarioOutrasInfo;
use App\Models\Funcionario\FuncionarioQuadroHorario;
use App\Models\Funcionario\FuncionarioRemuneracao;
use App\Models\Funcionario\FuncionarioRemuneracaoTipo;
use App\Repositories\FuncionarioRepository;
use app\Repositories\Pessoa\PessoaRepository;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FuncionarioService
{
    private $pessoaRepository;
    private $funcionarioRepository;

    public function __construct(
        PessoaRepository $pessoaRepository,
        FuncionarioRepository $funcionarioRepository
    )
    {
        $this->pessoaRepository = $pessoaRepository;
        $this->funcionarioRepository = $funcionarioRepository;
    }

    public function buscarTodos(String $permissao)
    {
        $funcionarios = $this->funcionarioRepository->buscarTodos($permissao);

        $funcionariosDTO = $funcionarios->map(function ($funcionario) {
            return FuncionarioDTO::fromArray($funcionario->toArray());
        })->toArray();

        return $funcionariosDTO;
    }
    public function pegarFuncionarios(array $parametros = []) : PaginacaoDTO
    {
        $funcionarios = $this->funcionarioRepository->pegarFuncionarios($parametros);

        $itens = collect($funcionarios->items())->map(function ($funcionario) {
            return $funcionario;
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $funcionarios->currentPage(),
            $funcionarios->lastPage(),
            $funcionarios->total(),
            $funcionarios->perPage()
        );
    }

    public function pegarFuncionarioPorId(int $id)
    {
        $funcionario = $this->funcionarioRepository->pegarFuncionarioPorId($id, ['pessoa']);

        return $funcionario;
    }

    public function cadastrarFuncionario(array $dados) : Funcionario
    {
        DB::beginTransaction();

        try {

            if(!empty($dados['imagem'])) {
                $url = UploadSeguroHelper::salvarImagem($dados['imagem'], 'funcionario');
                $dados['imagem'] = $url;
            }

            $pessoaDTO = PessoaCadastrarDTO::fromArray($dados)->toArray();


            $pessoa = $this->pessoaRepository->cadastrarOuAtualizarPessoa($pessoaDTO);

            $dados['id_pessoa'] = $pessoa->id_pessoa;

            $funcionarioDTO = CadastrarFuncionarioDTO::fromArray($dados);

            $funcionario = $this->funcionarioRepository->cadastrarFuncionario($funcionarioDTO);

            DB::commit();

            return $funcionario;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarFuncionario(array $dados, int $id_funcionario) : FuncionarioDTO
    {
        $funcionarioDTO = AtualizarFuncionarioDTO::fromArray($dados);

        $funcionario = $this->funcionarioRepository->atualizarFuncionario($funcionarioDTO, $id_funcionario);

        $funcionarioDTO = FuncionarioDTO::fromArray($funcionario->toArray());

        return $funcionarioDTO;
    }

    public function cadastrarDocumento(UploadedFile $arquivo, int $id_funcionario, int $id_docfuncional ) : FuncionarioDocs
    {

        $url = UploadSeguroHelper::salvarImagem($arquivo, 'funcionario/documentos');
        $nome_arquivo = $arquivo->getClientOriginalName();
        $extensao_arquivo = $arquivo->getClientOriginalExtension();

        $FuncionarioDocumentoDTO = new CadastrarDocumentoDTO(
            $id_funcionario,
            $id_docfuncional,
            $extensao_arquivo,
            $nome_arquivo,
            $url
        );

        return $this->funcionarioRepository->cadastrarDocumento($FuncionarioDocumentoDTO);
    }

    public function pegarDocumentos(array $parametros = [], $id_funcionario = null) : PaginacaoDTO
    {
        $funcionarioDocs = $this->funcionarioRepository->pegarDocumentos($parametros, $id_funcionario);

        $itens = collect($funcionarioDocs->items())->map(function ($documento) {
            return FuncionarioDocumentoDTO::fromArray($documento->toArray())->toArray();
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $funcionarioDocs->currentPage(),
            $funcionarioDocs->lastPage(),
            $funcionarioDocs->total(),
            $funcionarioDocs->perPage()
        );
    }

    public function deletarDocumento(int $id_documento) : bool
    {
        return $this->funcionarioRepository->deletarDocumento($id_documento);
    }

    public function buscarDocumentoTipo() : Collection
    {
        return $this->funcionarioRepository->buscarDocumentoTipo();
    }

    public function cadastrarDocumentoTipo($dados)
    {
        $dto = CadastrarDocumentoTipoDTO::fromArray($dados);

        return $this->funcionarioRepository->cadastrarDocumentoTipo($dto);
    }

    public function buscarInfosPorIdFuncionario(int $id_funcionario, array $parametros = []) : PaginacaoDTO
    {
        $infos =  $this->funcionarioRepository->buscarInfosPorIdFuncionario($id_funcionario, $parametros);

        $itens = collect($infos->items())->map(function ($info) {
            return FuncionarioOutrasInfoDTO::fromArray($info->toArray());
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $infos->currentPage(),
            $infos->lastPage(),
            $infos->total(),
            $infos->perPage()
        );
    }

    public function cadastrarInfo(string $dado, int $id_funcionario, int $id_funcionario_lista_info) : FuncionarioOutrasInfo
    {
        return $this->funcionarioRepository->cadastrarInfo($dado, $id_funcionario, $id_funcionario_lista_info);
    }

    public function deletarInfo(int $id_funcionario_outrasinfo) : bool
    {
        return $this->funcionarioRepository->deletarInfo($id_funcionario_outrasinfo);
    }

    public function pegarListaInfo() : Collection
    {
        return $this->funcionarioRepository->pegarListaInfo();
    }

    public function cadastrarListaInfo(string $descricao) : FuncionarioListaInfo
    {
        return $this->funcionarioRepository->cadastrarListaInfo($descricao);
    }

    public function pegarRemuneracaoTipo() : Collection
    {
        return $this->funcionarioRepository->pegarRemuneracaoTipo();
    }

    public function cadastrarRemuneracaoTipo(string $descricao) : FuncionarioRemuneracaoTipo
    {
        return $this->funcionarioRepository->cadastrarRemuneracaoTipo($descricao);
    }

    public function buscarRemuneracaoPorFuncionario(int $id_funcionario, $parametros = []) : PaginacaoDTO
    {
        $remuneracoes = $this->funcionarioRepository->buscarRemuneracaoPorFuncionario($id_funcionario,$parametros);

        $itens = collect($remuneracoes->items())->map(function ($remuneracao) {
            return FuncionarioRemuneracaoDTO::fromArray($remuneracao->toArray())->toArray();
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $remuneracoes->currentPage(),
            $remuneracoes->lastPage(),
            $remuneracoes->total(),
            $remuneracoes->perPage()
        );
    }

    public function cadastrarRemuneracao(array $dados) : FuncionarioRemuneracao
    {
        $remuneracao = CadastrarRemuneracaoDTO::fromArray($dados);

        return $this->funcionarioRepository->cadastrarRemuneracao($remuneracao);
    }

    public function deletarRemuneracao(int $id_remuneracao) : bool
    {
        return $this->funcionarioRepository->deletarRemuneracao($id_remuneracao);
    }

    public function buscarRemuneracaoTotalPorFuncionario(int $id_funcionario)
    {
        return $this->funcionarioRepository->buscarRemuneracaoTotalPorFuncionario($id_funcionario);
    }

    public function cadastrarQuadroHorario(array $dados, int $id_funcionario) : FuncionarioQuadroHorario
    {
        $dados['id_funcionario'] = $id_funcionario;

        $quadroHorario = CadastrarQuadroHorarioDTO::fromArray($dados);

        return $this->funcionarioRepository->cadastrarQuadroHorario($quadroHorario);
    }

    public function buscarQuadroHorarioPorFuncionario(int $id_funcionario) : FuncionarioQuadroHorarioDTO
    {
        $quadroHorario = $this->funcionarioRepository->buscarQuadroHorarioPorFuncionario($id_funcionario);

        return FuncionarioQuadroHorarioDTO::fromArray($quadroHorario->toArray());
    }

    public function buscarEscalaQuadroHorario() : Collection
    {
        return $this->funcionarioRepository->buscarEscalaQuadroHorario();
    }

    public function buscarTipoQuadroHorario() : Collection
    {
        return $this->funcionarioRepository->buscarTipoQuadroHorario();
    }

    public function buscarDependentesPorFuncionario(array $dados, int $id_funcionario) : PaginacaoDTO
    {
        $depentendes = $this->funcionarioRepository->buscarDependentesPorFuncionario($dados, $id_funcionario, ['parentesco', 'pessoa']);

        $itens = collect($depentendes->items())->map(function ($dependente) {
            return FuncionarioDependenteDTO::fromArray($dependente->toArray())->toArray();
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $depentendes->currentPage(),
            $depentendes->lastPage(),
            $depentendes->total(),
            $depentendes->perPage()
        );

        return $this->funcionarioRepository->buscarDependentesPorFuncionario($dados, $id_funcionario, ['pessoa', 'funcionario', 'parentesco']);
    }

    public function cadastrarDependente(array $dados) : FuncionarioDependente
    {
        try {
            $depentendeCadastrarDTO = CadastrarDependenteFuncionarioDTO::fromArray($dados);

            $depentende = $this->funcionarioRepository->cadastrarDependente($depentendeCadastrarDTO);

            return $depentende;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function excluirDependente(int $id_dependente) : bool
    {
        return $this->funcionarioRepository->excluirDependente($id_dependente);
    }

    public function buscarDependenteParentesco() : Collection
    {
        return $this->funcionarioRepository->buscarDependenteParentesco();
    }

    public function cadastrarDependenteParentesco(array $dados) : FuncionarioDependenteParentesco
    {
        return $this->funcionarioRepository->cadastrarDependenteParentesco($dados);
    }
}
