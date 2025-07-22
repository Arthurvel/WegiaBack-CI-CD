<?php

namespace App\Services;

use App\DTOs\Perfil\CadastrarPerfilDTO;
use App\Repositories\PerfilRepository;

class PerfilService
{
    private $perfilRepository;

    public function __construct(
      PerfilRepository $perfilRepository
    )
    {
        $this->perfilRepository = $perfilRepository;
    }

    public function cadastrarPerfil(CadastrarPerfilDTO $dto)
    {
        return $this->perfilRepository->cadastrarPerfil($dto);
    }
}