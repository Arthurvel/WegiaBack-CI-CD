<?php

namespace App\Services;

use App\DTOs\Funcionario\AtualizarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDependenteFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarDocumentoDTO;
use App\DTOs\Funcionario\CadastrarDocumentoTipoDTO;
use App\DTOs\Funcionario\CadastrarFuncionarioDTO;
use App\DTOs\Funcionario\CadastrarQuadroHorarioDTO;
use App\DTOs\Funcionario\CadastrarRemuneracaoDTO;
use app\DTOs\Funcionario\FuncionarioBuscarDTO;
use app\DTOs\Funcionario\FuncionarioBuscarTodosDTO;
use app\DTOs\Funcionario\FuncionarioCadastrarDTO;
use App\DTOs\Funcionario\FuncionarioDependenteDTO;
use App\DTOs\Funcionario\FuncionarioDocumentoDTO;
use App\DTOs\Funcionario\FuncionarioDTO;
use App\DTOs\Funcionario\FuncionarioOutrasInfoDTO;
use App\DTOs\Funcionario\FuncionarioQuadroHorarioDTO;
use App\DTOs\Funcionario\FuncionarioRemuneracaoDTO;
use App\DTOs\PaginacaoDTO;
use app\DTOs\Pessoa\PessoaCadastrarDTO;
use App\DTOs\Pessoa\PessoaComFotoCadastrarDTO;
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
use App\Services\Base\BaseService;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FuncionarioService extends BaseService
{
    private $pessoaRepository;

    public function __construct(
        PessoaRepository $pessoaRepository,
        FuncionarioRepository $repository
    )
    {
        parent::__construct($repository);
        $this->pessoaRepository = $pessoaRepository;
    }

    public function buscarTodosFiltrados(FuncionarioBuscarTodosDTO $dto)
    {
        return $this->repository->buscarTodosFiltrados($dto);
    }
    public function pegarFuncionarios(FuncionarioBuscarDTO $dto)
    {
        return $this->repository->pegarFuncionarios($dto);
    }

    public function cadastrarFuncionario(FuncionarioCadastrarDTO $funcionarioDTO, PessoaComFotoCadastrarDTO $pessoaDTO) : Funcionario
    {
        DB::beginTransaction();

        try {

            $url = '';
            if(!empty($pessoaDTO->imagem)) {
                $url = UploadSeguroHelper::salvarImagem($pessoaDTO->imagem, 'funcionario');
            }

            $pessoaFotoStringDTO = PessoaCadastrarDTO::fromArray([
                ...$pessoaDTO->toArray(),
                'imagem' => $url,
            ]);

            $pessoa = $this->pessoaRepository->cadastrarOuAtualizarPessoa($pessoaFotoStringDTO);

            $funcionarioDTO->id_pessoa = $pessoa->id_pessoa;

            $funcionario = $this->repository->criar($funcionarioDTO);

            DB::commit();

            return $funcionario;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
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

        return $this->repository->cadastrarDocumento($FuncionarioDocumentoDTO);
    }

    public function buscarRemuneracaoPorFuncionario(int $id_funcionario, $parametros = []) : PaginacaoDTO
    {
        $remuneracoes = $this->repository->buscarRemuneracaoPorFuncionario($id_funcionario,$parametros);

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


    public function buscarDependentesPorFuncionario(array $dados, int $id_funcionario) : PaginacaoDTO
    {
        $depentendes = $this->repository->buscarDependentesPorFuncionario($dados, $id_funcionario, ['parentesco', 'pessoa']);

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

        return $this->repository->buscarDependentesPorFuncionario($dados, $id_funcionario, ['pessoa', 'funcionario', 'parentesco']);
    }

    public function cadastrarDependenteParentesco(array $dados) : FuncionarioDependenteParentesco
    {
        return $this->repository->cadastrarDependenteParentesco($dados);
    }
}
