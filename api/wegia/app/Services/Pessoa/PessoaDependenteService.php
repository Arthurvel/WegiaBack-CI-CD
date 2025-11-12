<?php

namespace app\Services\Pessoa;

use app\DTOs\Pessoa\Dependente\PessoaDependenteBuscarTodosPorIdDTO;
use app\DTOs\Pessoa\Dependente\PessoaDependenteCadastrarDTO;
use app\Repositories\Pessoa\PessoaDependenteRepository;
use App\Services\Base\BaseService;

class PessoaDependenteService extends BaseService
{

    public function __construct
    (
        PessoaDependenteRepository $repository,
    )
    {
        parent::__construct($repository);
    }

    public function buscarDependentesPorIdPessoa(int $id, PessoaDependenteBuscarTodosPorIdDTO $dto)
    {
        return $this->repository->buscarDependentesPorIdPessoa($id, $dto);
    }
    public function criarDependente(PessoaDependenteCadastrarDTO $dto)
    {
        if($dto->id_dependente_pessoa === $dto->id_pessoa){
            throw new \DomainException('Uma pessoa não pode ser dependente dela mesma.');
        }

        if($this->repository->jaExisteRelacionamento($dto->id_pessoa, $dto->id_dependente_pessoa)) {
            throw new \DomainException('Esse relacionamento de dependência já existe.');
        }

        return $this->repository->criar($dto);
    }

}
