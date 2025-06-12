<?php

namespace App\Services;

use App\DTOs\Pet\AtualizarAtendimentoDTO;
use App\DTOs\Pet\AtualizarFichaMedicaDTO;
use App\DTOs\Pet\CriarAtendimentoDTO;
use App\DTOs\Pet\CriarEspecieDTO;
use App\DTOs\Pet\CriarFichaMedicaDTO;
use App\DTOs\Pet\CriarRacaDTO;
use App\Models\Especie;
use App\Models\Pet\Atendimento;
use App\Models\Pet\FichaMedica;
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
    
    public function criarFichaMedica(array $dados, int $id_pet) : FichaMedica
    {
        $dados['id_pet'] = $id_pet;
        $criarfichamedicadto = CriarFichaMedicaDTO::fromArray($dados);
        return $this->petRepository->criarFichaMedica($criarfichamedicadto); 
    }
    public function atualizarFichaMedica(array $dados, int $id_ficha_medica) : FichaMedica
    {
        $atualizarfichamedicadto = AtualizarFichaMedicaDTO::fromArray($dados);
        return $this->petRepository->atualizarFichaMedica($atualizarfichamedicadto, $id_ficha_medica); 
    }
    public function pegarFichaMedicaPorPet(int $id_pet) : FichaMedica
    {
        return $this->petRepository->pegarFichaMedicaPorPet($id_pet); 
    }
    public function criarAtendimento(array $dados, int $id_ficha_medica) : Atendimento
    {
        $dados['id_ficha_medica'] = $id_ficha_medica;
        $criaratendimentodto = CriarAtendimentoDTO::fromArray($dados);
        return $this->petRepository->criarAtendimento($criaratendimentodto); 
    }
    public function deletarAtendimento(int $id_atendimento) : bool
    {
        return $this->petRepository->deletarAtendimento($id_atendimento); 
    }
    public function atualizarAtendimento(array $dados, int $id_atendimento) : Atendimento
    {
        $atualizaratendimentodto = AtualizarAtendimentoDTO::fromArray($dados);
        return $this->petRepository->atualizarAtendimento($atualizaratendimentodto, $id_atendimento); 
    }
}

