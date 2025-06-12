<?php

namespace App\Repositories;

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
    public function criarFichaMedica(CriarFichaMedicaDTO $dados) : FichaMedica
    {
        return FichaMedica::create($dados->toArray());
    }
    public function atualizarFichaMedica(AtualizarFichaMedicaDTO $dados, int $id_ficha_medica) : FichaMedica
    {
        $ficha_medica = $this->pegarFichaMedicaPorId($id_ficha_medica);

        $ficha_medica->update($dados->toArray());
        $ficha_medica->save();

        return $ficha_medica;
    }
    public function pegarFichaMedicaPorId(int $id_ficha_medica) : FichaMedica
    {
            return FichaMedica::findOrFail($id_ficha_medica);    
    }
    public function pegarFichaMedicaPorPet(int $id_pet) : FichaMedica
    {
            return FichaMedica::where('id_pet', $id_pet)->firstOrFail();    
    }
    public function criarAtendimento(CriarAtendimentoDTO $dados) : Atendimento
    {
        return Atendimento::create($dados->toArray());
    }
    public function deletarAtendimento($id_atendimento) : bool
    {
        $atendimento = $this->pegarAtendimentoPorId($id_atendimento);
        return $atendimento->delete();
    }
    public function atualizarAtendimento(AtualizarAtendimentoDTO $dados, int $id_atendimento) : Atendimento
    {
        $atendimento = $this->pegarAtendimentoPorId($id_atendimento);

        $atendimento->update($dados->toArray());
        $atendimento->save();

        return $atendimento;
    }
    public function pegarAtendimentoPorId(int $id_atendimento) : Atendimento
    {
            return Atendimento::findOrFail($id_atendimento);    
    }
}