<?php

namespace app\Services\Pessoa;

use app\DTOs\Pessoa\Arquivo\PessoaArquivoBuscarPaginadoDTO;
use app\DTOs\Pessoa\Arquivo\PessoaArquivoCadastrarDTO;
use app\DTOs\Pessoa\Arquivo\PessoaArquivoComFileCadastrarDTO;
use App\Helpers\UploadSeguroHelper;
use app\Repositories\Pessoa\PessoaArquivoRepository;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class PessoaArquivoService extends BaseService
{

    public function __construct(
        PessoaArquivoRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function cadastrarArquivo(PessoaArquivoComFileCadastrarDTO $dto)
    {
        return DB::Transaction(function () use ($dto) {

            $url = UploadSeguroHelper::salvarImagem($dto->arquivo, 'pessoa');

            $fotoCadastrarDto = PessoaArquivoCadastrarDTO::fromArray([
                'arquivo'                => $url,
                'nome_arquivo'           => $dto->arquivo->getClientOriginalName(),
                'extensao_arquivo'       => $dto->arquivo->extension(),
                'id_pessoa_tipo_arquivo' => $dto->id_pessoa_tipo_arquivo,
                'id_pessoa'              => $dto->id_pessoa
            ]);

            return $this->repository->criar($fotoCadastrarDto);
        });
    }

    public function buscarTodosPaginados(PessoaArquivoBuscarPaginadoDTO $dto)
    {
        return $this->repository->buscarTodosPaginados($dto);
    }

}
