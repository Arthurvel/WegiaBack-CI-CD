<?php

namespace App\Repositories;

use App\DTOs\Pet\CriarEspecieDTO;
use App\DTOs\Pet\CriarRacaDTO;
use App\Models\Especie;
use App\Models\Raca;
use Illuminate\Database\Eloquent\Collection;

class PetRepository
{
    public function criarEspecie(CriarEspecieDTO $dados) : Especie
    {
        return Especie::create($dados->toArray());
    }
    public function pegarEspecie() : Collection
    {
        return Especie::get();
    }
    public function criarRaca(CriarRacaDTO $dados) : Raca
    {
        return Raca::create($dados->toArray());
    }
    public function pegarRaca() : Collection
    {
        return Raca::get();
    }
}