<?php

namespace app\Services\Atendido\Aceitacao;

use app\DTOs\Atendido\Aceitacao\AtendidoAceitacaoPaArquivoCadastrarDTO;
use App\Helpers\UploadSeguroHelper;
use app\Repositories\Atendido\Aceitacao\AtendidoAceitacaoPaArquivoRepository;
use App\Services\Base\BaseService;

class AtendidoAceitacaoPaArquivoService extends BaseService
{

    public function __construct(
        AtendidoAceitacaoPaArquivoRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function cadastrarArquivo(AtendidoAceitacaoPaArquivoCadastrarDTO $dto)
    {

        $caminho = UploadSeguroHelper::salvarImagem($dto->arquivo, 'atendido/aceitacao');

        $dto->arquivo = $caminho;

        return $this->repository->criar($dto);
    }

}

