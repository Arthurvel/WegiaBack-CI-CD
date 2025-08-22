<?php

namespace Modules\Pet\app\Services;

use App\Services\Base\BaseService;
use Modules\Pet\app\DTO\AdocaoCadastrarDTO;
use Modules\Pet\app\Repositories\AdocaoRepository;

class AdocaoService extends BaseService
{

    public function __construct
    (
        AdocaoRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function criarComValidacao(AdocaoCadastrarDTO $dto)
    {
        $adocao = $this->repository->existePetAdotado($dto->id_pet);

        if ($adocao) {
            throw new \Exception('Este pet já foi adotado.');
        }

        return $this->repository->criar($dto);
    }
}
