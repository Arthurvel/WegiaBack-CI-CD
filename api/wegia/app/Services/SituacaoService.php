<?php

namespace App\Services;


use App\DTOs\Situacao\SituacaoDTO;
use App\Repositories\SituacaoRepository;

class SituacaoService
{
    private $situacaoRepository;

    public function __construct(
        SituacaoRepository $situacaoRepository
    )
    {
        $this->situacaoRepository = $situacaoRepository;
    }

    public function pegarSituacoes() : object
    {
        return  $this->situacaoRepository->pegarSituacoes()->map(function($situacao){
            return SituacaoDTO::fromArray($situacao->toArray());
        });
    }

    public function criarSituacao(string $situacao) : SituacaoDTO
    {
        return SituacaoDTO::fromArray($this->situacaoRepository->criarSituacao($situacao)->toArray());
    }

    public function deletarSituacao(int $id_situacao) : bool
    {
        return $this->situacaoRepository->deletarSituacao($id_situacao);
    }
}