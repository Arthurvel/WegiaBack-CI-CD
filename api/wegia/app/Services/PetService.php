<?php

namespace App\Services;

use App\DTOs\Pet\CriarEspecieDTO;
use App\DTOs\Pet\CriarRacaDTO;
use App\Models\Especie;
use App\Models\Raca;
use App\Repositories\PetRepository;
use Illuminate\Database\Eloquent\Collection;

class PetService
{
    private $petRepository;

    public function __construct(
        PetRepository $petRepository
    )
    {
        $this->petRepository = $petRepository;
    }
    public function criarEspecie(array $dados) : Especie
    {
        $criarespeciedto = CriarEspecieDTO::fromArray($dados);
        return $this->petRepository->criarEspecie($criarespeciedto); 
    }
    public function pegarEspecie() : Collection
    {
        return $this->petRepository->pegarEspecie(); 
    }
    public function criarRaca(array $dados) : Raca
    {
        $criarracadto = CriarRacaDTO::fromArray($dados);
        return $this->petRepository->criarRaca($criarracadto); 
    }
    public function pegarRaca() : Collection
    {
        return $this->petRepository->pegarEspecie(); 
    }
}