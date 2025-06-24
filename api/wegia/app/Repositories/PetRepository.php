<?php

namespace App\Repositories;

use App\DTOs\Pet\AtualizarAtendimentoDTO;
use App\DTOs\Pet\AtualizarFichaMedicaDTO;
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
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
    public function pegarAtendimentoPorFichaMedica(int $id_ficha_medica, array $parametros) : LengthAwarePaginator
    {
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;
        $ordenacao      = $parametros['ordenacao'] ?? null;
        $tipoOrdenacao  = $parametros['tipoOrdenacao'] ?? 'ASC';
        $buscar         = $parametros['buscar'] ?? null;
        return Atendimento::where('id_ficha_medica', $id_ficha_medica)
        ->when(!is_null($buscar), function ($q) use ($buscar) {
            return $q->where('data_atendimento', 'LIKE', $buscar)
                ->orWhere('descricao', 'LIKE', $buscar);
        })
        ->when(!is_null($ordenacao), function ($q) use ($ordenacao, $tipoOrdenacao) {
                return $q->orderBy("{$ordenacao}", $tipoOrdenacao);
        })
        ->paginate($itensPorPagina, ['*'], 'page', $pagina);

    }
    public function criarMedicacao(CriarMedicacaoDTO $dados) : Medicacao
    {
        return Medicacao::create($dados->toArray());
    }
    public function deletarMedicacao($id_medicacao) : bool
    {
        $medicacao = $this->pegarMedicacaoPorId($id_medicacao);
        return $medicacao->delete();
    }
    public function pegarMedicacaoPorId(int $id_medicacao) : Medicacao
    {
            return Medicacao::findOrFail($id_medicacao);
    }
    public function pegarMedicacaoPorAtendimento(int $id_pet_atendimento, array $parametros = []) : LengthAwarePaginator
    {
        $itensPorPagina = $parametros['itensPorPagina'] ?? 10;
        $pagina         = $parametros['pagina'] ?? 1;
        return Medicacao::where('id_pet_atendimento', $id_pet_atendimento)
                ->paginate($itensPorPagina, ['*'], 'page', $pagina);

    }
    public function criarMedicamento(CriarMedicamentoDTO $dados) : Medicamento
    {
        return Medicamento::create($dados->toArray());
    }
    public function deletarMedicamento($id_medicamento) : bool
    {
        $medicamento = $this->pegarMedicamentoPorId($id_medicamento);
        return $medicamento->delete();
    }
    public function pegarMedicamentoPorId(int $id_medicamento) : Medicamento
    {
            return Medicamento::findOrFail($id_medicamento);
    }
    public function pegarMedicamento() : Collection
    {
        return Medicamento::get();
    }
}