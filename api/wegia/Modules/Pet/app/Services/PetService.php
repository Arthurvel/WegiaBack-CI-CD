<?php

namespace Modules\Pet\app\Services;

use App\Helpers\UploadSeguroHelper;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Pet\app\DTO\PetAtualizarComFoto;
use Modules\Pet\app\DTO\PetAtualizarDTO;
use Modules\Pet\app\DTO\PetBuscarTodosDTO;
use Modules\Pet\app\DTO\PetCadastrarComFotoDto;
use Modules\Pet\app\DTO\PetFotoCadastrarDTO;
use Modules\Pet\app\DTO\PetCadastrarDTO;
use Modules\Pet\app\Repositories\PetFotoRepository;
use Modules\Pet\app\Repositories\PetRepository;

class PetService extends BaseService
{
    private PetFotoRepository $petFotoRepository;

    public function __construct
    (
        PetRepository $repository,
        PetFotoRepository $petFotoRepository
    )
    {
        parent::__construct($repository);
        $this->petFotoRepository = $petFotoRepository;
    }

    public function buscarTodosPaginado(PetBuscarTodosDTO $dto) {
        return $this->repository->buscarTodosPaginado($dto);
    }

    public function criarComFoto(PetCadastrarComFotoDto $dto)
    {
        return DB::Transaction(function () use ($dto) {

            $idFoto = null;
            if (!is_null($dto->foto)) {
                $url = UploadSeguroHelper::salvarImagem($dto->foto, 'pets');

                $fotoCadastrarDto = PetFotoCadastrarDTO::fromArray([
                    'arquivo_foto_pet' => $url,
                    'arquivo_foto_pet_nome' => $dto->foto->getClientOriginalName(),
                    'arquivo_foto_pet_extensao' => $dto->foto->extension()
                ]);

                $fotoModel = $this->petFotoRepository->criar($fotoCadastrarDto);
                $idFoto = $fotoModel->id_pet_foto;
            }

            $pet = $this->repository->criar(
                PetCadastrarDTO::fromArray([
                    'nome' => $dto->nome,
                    'data_nascimento' => $dto->data_nascimento,
                    'data_acolhimento' => $dto->data_acolhimento,
                    'sexo' => $dto->sexo,
                    'caracteristicas_especificas' => $dto->caracteristicas_especificas,
                    'id_pet_foto' => $idFoto,
                    'id_pet_especie' => $dto->id_pet_especie,
                    'id_pet_raca' => $dto->id_pet_raca,
                    'cor' => $dto->cor
                ])
            );

            return $pet;
        });
    }

    public function atualizarComFoto(int $id, PetAtualizarComFoto $dto)
    {
        $pet = $this->repository->buscarPorId($id, []);

        return DB::Transaction(function () use ($dto, $pet, $id) {

            $foto = $dto->foto;
            unset($dto->foto);
            $atualizadoDTO = PetAtualizarDTO::fromArray($dto->toArrayUpdate());

            if (!is_null($foto)) {
                $url = UploadSeguroHelper::salvarImagem($foto, 'pets');

                $fotoCadastrarDto = PetFotoCadastrarDTO::fromArray([
                    'arquivo_foto_pet' => $url,
                    'arquivo_foto_pet_nome' => $foto->getClientOriginalName(),
                    'arquivo_foto_pet_extensao' => $foto->extension()
                ]);

                $fotoModel = null;

                if($pet->id_pet_foto) {
                    $fotoModel = $this->petFotoRepository->atualizar((int) $pet->id_pet_foto, $fotoCadastrarDto);
                } else {
                    $fotoModel = $this->petFotoRepository->criar($fotoCadastrarDto);
                }


                $atualizadoDTO->id_pet_foto = $fotoModel->id_pet_foto;
            }



            $this->repository->atualizar($id, $atualizadoDTO);
            return $dto;
        });
    }
}
