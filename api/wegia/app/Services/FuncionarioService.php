<?php

namespace App\Services;

use App\DTOs\Funcionario\CadastrarDocumentoDTO;
use App\DTOs\Funcionario\FuncionarioDTO;
use App\DTOs\PaginacaoDTO;
use App\Models\Funcionario;
use App\Models\FuncionarioDocs;
use App\Repositories\PessoaRepository;
use App\Repositories\FuncionarioRepository;
use Illuminate\Support\Facades\DB;
use Exception;
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
        return $this->funcionarioRepository->pegarFuncionarios($parametros);
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
}