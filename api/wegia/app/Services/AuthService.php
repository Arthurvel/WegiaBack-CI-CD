<?php

namespace App\Services;

use App\Models\Pessoa;
use Carbon\Carbon;

class AuthService
{

    public function gerarToken(Pessoa $pessoa, $expiraEm = null) : array
    {
        $expiraEm = $expiraEm ?? Carbon::now()->addHour();

        $token = $pessoa->createToken('authToken', ['*'],$expiraEm)
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