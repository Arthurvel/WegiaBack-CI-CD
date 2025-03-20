<?php

namespace App\Repositories;

use App\Models\Situacao;
use Illuminate\Database\Eloquent\Collection;

class SituacaoRepository
{

    public function pegarSituacoes() : Collection
    {
        return Situacao::all();
    }

    public function pegarUmaSituacao(int $id_situacao) : Situacao
    {
        return Situacao::findOrFail($id_situacao);
    }

    public function criarSituacao(string $situacao) : Situacao
    {
        return Situacao::create(
            [
                'situacoes' => $situacao
            ]
        );
    }

    public function deletarSituacao(int $id_situacao) : bool
    {
        $situacao = $this->pegarUmaSituacao($id_situacao);
        return $situacao->delete();
    }

}