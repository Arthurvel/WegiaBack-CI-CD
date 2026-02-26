<?php

namespace app\Services\Configuracao;
use App\DTOs\BaseDTO;
use app\DTOs\Configuracao\ImagemCadastrarDTO;
use App\Helpers\UploadSeguroHelper;
use app\Repositories\Configuracao\ImagemRepository;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;


class ImagemService extends BaseService
{

    public function __construct(
        ImagemRepository $repository
    )
    {
        parent::__construct($repository);
    }

    public function criarComImagem(ImagemCadastrarDTO $dto)
    {
        return DB::Transaction(function () use ($dto) {

            if ($this->repository->nomeExiste($dto->nome)) {
                $ultimoNumero = $this->repository->quantidadeExistenteDoNome($dto->nome);

                $proximoNumero = $ultimoNumero ? $ultimoNumero + 1 : 1;
                $dto->nome = $dto->nome . ' (' . $proximoNumero . ')';
            }

            $url = UploadSeguroHelper::salvarImagem($dto->imagem, 'sistema');

            $dto->imagem = $url;

            return $this->repository->criar($dto);
        });
    }

}
