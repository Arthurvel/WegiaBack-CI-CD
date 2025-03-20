<?php

namespace App\Services;

use App\DTOs\Funcionario\AtualizarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDocumentoDTO;
use App\DTOs\Funcionario\FuncionarioDocumentoDTO;
use App\DTOs\Funcionario\FuncionarioDTO;
use App\DTOs\Funcionario\FuncionarioOutrasInfoDTO;
use App\DTOs\PaginacaoDTO;
use App\Models\Funcionario\Funcionario;
use App\Models\Funcionario\FuncionarioDocs;
use App\Models\Funcionario\FuncionarioListaInfo;
use App\Models\Funcionario\FuncionarioOutrasInfo;
use App\Repositories\PessoaRepository;
use App\Repositories\FuncionarioRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;

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

    public function pegarFuncionarios(array $parametros = []) : PaginacaoDTO
    {
        $funcionarios = $this->funcionarioRepository->pegarFuncionarios($parametros);

        $itens = collect($funcionarios->items())->map(function ($funcionario) {
            return FuncionarioDTO::fromArray($funcionario->toArray());
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $funcionarios->currentPage(),
            $funcionarios->lastPage(),
            $funcionarios->total(),
            $funcionarios->perPage()
        );
    }

    public function cadastrarFuncionario(array $dados) : Funcionario
    {
        DB::beginTransaction();

        try {
            $pessoa = $this->pessoaRepository->cadastrarPessoa([
                'imagem'          => $dados['imagem'],
                'nome'            => $dados['nome'],
                'sobrenome'       => $dados['sobrenome'],
                'sexo'            => $dados['sexo'],
                'telefone'        => $dados['telefone'],
                'data_nascimento' => $dados['data_nascimento'],
                'registro_geral'  => $dados['registro_geral'],
                'orgao_emissor'   => $dados['orgao_emissor'],
                'data_expedicao'  => $dados['data_expedicao'],
                'cpf'             => $dados['cpf'],
            ]);

            $funcionarioDTO = FuncionarioDTO::fromArray($dados);

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
        $nome_arquivo = $arquivo->getClientOriginalName();
        $extensao_arquivo = $arquivo->getClientOriginalExtension();

        $arquivo_b64 = base64_encode(file_get_contents($arquivo->getRealPath()));

        $FuncionarioDocumentoDTO = new CadastrarDocumentoDTO(
            $id_funcionario,
            $id_docfuncional,
            $extensao_arquivo,
            $nome_arquivo,
            $arquivo_b64
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
}