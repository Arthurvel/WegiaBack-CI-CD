<?php

namespace app\Services\Pessoa;

use App\DTOs\PaginacaoDTO;
use App\DTOs\Pessoa\CadastrarPessoaDependenteDTO;
use App\DTOs\Pessoa\PessoaAtualizarDTO;
use App\DTOs\Pessoa\PessoaAtualizarSenhaDTO;
use App\DTOs\Pessoa\PessoaCadastrarDTO;
use App\DTOs\Pessoa\PessoaDependenteDTO;
use App\Helpers\UploadSeguroHelper;
use App\Models\Pessoa\Pessoa;
use App\Models\Pessoa\PessoaDependente;
use app\Repositories\Pessoa\PessoaRepository;
use App\Services\Base\BaseService;

class PessoaService extends BaseService
{
    public function __construct
    (
        PessoaRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function cadastrarPessoaComFoto(PessoaCadastrarDTO $pessoa): Pessoa
    {
        if (!empty($pessoa->imagem)) {
            $url = UploadSeguroHelper::salvarImagem($pessoa->imagem, 'pessoa');
            $pessoa->imagem = $url;
        }

        return $this->repository->criar($pessoa);
    }

    public function buscarPessoaPorCpf(string $cpf): Pessoa
    {
        return $this->repository->buscarPessoaPorCpf($cpf);
    }

    public function buscarPessoaPorCpfSemFormatacao(string $cpf): Pessoa
    {
        return $this->repository->buscarPessoaPorCpf($cpf);
    }

    public function buscarPessoaParaFiltros()
    {
        return $this->repository->buscarPessoaParaFiltros();
    }

    public function mudarSenha(PessoaAtualizarSenhaDTO $dto)
    {
        return $this->repository->mudarSenha($dto);
    }

    public function atualizarImagem(array $dados, String $id_pessoa)
    {
        $url = UploadSeguroHelper::salvarImagem($dados['imagem'], 'pessoa');

        $dto = PessoaAtualizarDTO::fromArray([
            'imagem' => $url
        ]);

        return $this->repository->atualizar($id_pessoa, $dto);
    }

    public function buscarDependentesPorIdPessoa(int $id_pessoa, array $filtros = []) : PaginacaoDTO
    {
        $dependentes = $this->repository->buscarDependentesPorIdPessoa($id_pessoa, $filtros);

        $itens = collect($dependentes->items())->map(function ($dependente) {
            return PessoaDependenteDTO::fromArray($dependente->toArray());
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $dependentes->currentPage(),
            $dependentes->lastPage(),
            $dependentes->total(),
            $dependentes->perPage()
        );
    }

    public function criarParentesco(array $dados, String $id_pessoa, int $id_dependente) : PessoaDependente
    {
        $array = [
            'id_pessoa' => $id_pessoa,
            'id_dependente_pessoa' => $id_dependente,
            'parentesco' => $dados['parentesco']
        ];
        $dependenteDTO = CadastrarPessoaDependenteDTO::fromArray($array);

        return $this->repository->criarParentesco($dependenteDTO);
    }

    public function deletarDependente(int $id_dependente) : bool
    {
        return $this->repository->deletarDependente($id_dependente);
    }
}
