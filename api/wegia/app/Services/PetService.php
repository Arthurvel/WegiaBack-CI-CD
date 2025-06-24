<?php

namespace App\Services;

use App\DTOs\PaginacaoDTO;
use App\DTOs\Pet\AtualizarAtendimentoDTO;
use App\DTOs\Pet\AtualizarFichaMedicaDTO;
use App\DTOs\Pet\BuscarAtendimentoDTO;
use App\DTOs\Pet\BuscarMedicacaoDTO;
use App\DTOs\Pet\CriarAtendimentoDTO;
use App\DTOs\Pet\CriarEspecieDTO;
use App\DTOs\Pet\CriarFichaMedicaDTO;
use App\DTOs\Pet\CriarMedicacaoDTO;
use App\DTOs\Pet\CriarMedicamentoDTO;
use App\DTOs\Pet\CriarRacaDTO;
use App\Models\Especie;
use App\Models\Pet\Atendimento;
use App\Models\Pet\FichaMedica;
use App\Models\Pet\Medicacao;
use App\Models\Pet\Medicamento;
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
        return $this->petRepository->pegarRaca();
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
    public function pegarAtendimentoPorFichaMedica(int $id_ficha_medica, array $parametros = []) : PaginacaoDTO
    {
        $atendimento = $this->petRepository->pegarAtendimentoporFichaMedica($id_ficha_medica, $parametros);
        $itens = collect($atendimento->items())->map(function ($atendimento) {
            return BuscarAtendimentoDTO::fromArray($atendimento->toArray())->toArray();
        })->toArray();
        return new PaginacaoDTO(
            $itens,
            $atendimento->currentPage(),
            $atendimento->lastPage(),
            $atendimento->total(),
            $atendimento->perPage()
        );
    }
    public function criarMedicacao(array $dados, int $id_pet_atendimento) : Medicacao
    {
        $dados['id_pet_atendimento'] = $id_pet_atendimento;
        $criarmedicacaodto = CriarMedicacaoDTO::fromArray($dados);
        return $this->petRepository->criarMedicacao($criarmedicacaodto);
    }
    public function deletarMedicacao(int $id_medicacao) : bool
    {
        return $this->petRepository->deletarMedicacao($id_medicacao);
    }
    public function pegarMedicacaoporAtendimento(int $id_pet_atendimento,array $parametros = []) : PaginacaoDTO
    {
        $medicacoes = $this->petRepository->pegarMedicacaoporAtendimento($id_pet_atendimento, $parametros);
        $itens = collect($medicacoes->items())->map(function ($medicacao) {
            return BuscarMedicacaoDTO::fromArray($medicacao->toArray())->toArray();
        })->toArray();

        return new PaginacaoDTO(
            $itens,
            $medicacoes->currentPage(),
            $medicacoes->lastPage(),
            $medicacoes->total(),
            $medicacoes->perPage()
        );
    }
    public function criarMedicamento(array $dados) : Medicamento
    {
        $criarmedicamentodto = CriarMedicamentoDTO::fromArray($dados);
        return $this->petRepository->criarMedicamento($criarmedicamentodto);
    }
    public function deletarMedicamento(int $id_medicamento) : bool
    {
        return $this->petRepository->deletarMedicamento($id_medicamento);
    }
    public function pegarMedicamento() : Collection
    {
        return $this->petRepository->pegarMedicamento();
    }
}

