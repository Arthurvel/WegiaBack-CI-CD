<?php

namespace App\Repositories;

use App\Models\Cargo;
use Illuminate\Database\Eloquent\Collection;

class CargoRepository
{

    public function pegarCargos() : Collection
    {
        return Cargo::all();
    }

    public function pegarUmCargo(int $id_cargo) : Cargo
    {
        return Cargo::findOrFail($id_cargo);
    }

    public function criarCargo(string $cargo) : Cargo
    {
        return Cargo::create(
            [
                'cargo' => $cargo
            ]
        );
    }

    public function deletarCargo(int $id_cargo) : bool
    {
        $cargo = $this->pegarUmCargo($id_cargo);
        return $cargo->delete();
    }

}