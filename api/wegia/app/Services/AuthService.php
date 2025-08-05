<?php

namespace App\Services;

use App\Models\Pessoa;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthService
{

    public function gerarToken(Pessoa $pessoa, $expiraEm = null) : array
    {
        $expiraEm = $expiraEm ?? Carbon::now()->addHour();

        $permissoes = collect();

        if ($pessoa->funcionario && $pessoa->funcionario->perfil && $pessoa->funcionario->perfil->permissoes) {
            $permissoes = $pessoa->funcionario->perfil->permissoes;
        }

        $abilities = $permissoes->pluck('nome')->map(function($nome) {
            return Str::slug($nome);
        })->toArray();

        $token = $pessoa->createToken('authToken', $abilities, $expiraEm)
            ->plainTextToken;

        return $this->retornoToken($token, $expiraEm);
    }

    public function revogarToken(Pessoa $user) : bool
    {
        return $user->currentAccessToken()->delete();
    }

    private function retornoToken(String $token, $expiraEm) : array
    {
        return [
            'tipo' => 'Bearer',
            'token' => $token,
            'expira_em' => $expiraEm->toDateTimeString(),
        ];
    }

}
