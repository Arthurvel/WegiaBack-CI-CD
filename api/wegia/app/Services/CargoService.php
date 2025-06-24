<?php

namespace App\Services;

use App\DTOs\Cargo\CargoDTO;
use App\Repositories\CargoRepository;

class CargoService
{
    private $cargoRepository;

    public function __construct(
        CargoRepository $cargoRepository
    )
    {
        $this->cargoRepository = $cargoRepository;
    }

    public function pegarCargos() : object
    {
        return  $this->cargoRepository->pegarCargos()->map(function($cargo){
            return CargoDTO::fromArray($cargo->toArray());
        });
    }

    public function criarCargo(string $cargo) : CargoDTO
    {
        return CargoDTO::fromArray($this->cargoRepository->criarCargo($cargo)->toArray());
    }

    public function deletarSituacao(int $id_cargo) : bool
    {
        return $this->cargoRepository->deletarCargo($id_cargo);
    }
}