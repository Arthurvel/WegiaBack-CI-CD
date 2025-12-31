<?php

namespace app\Services\Configuracao;

use app\DTOs\Configuracao\ImagemCadastrarDTO;
use app\DTOs\Configuracao\ImagemEmUmCampoAtualizarDTO;
use app\DTOs\Configuracao\ImagemEmUmCampoCadastrarDTO;
use app\DTOs\Configuracao\TabelaImagemCampoCadastrarOuAtualizarDTO;
use app\Repositories\Configuracao\TabelaImagemCampoRepository;
use App\Services\Base\BaseService;
use Illuminate\Support\Facades\DB;

class TabelaImagemCampoService extends BaseService
{

    private ImagemService $imagemService;

    public function __construct(
        TabelaImagemCampoRepository $repository,
        ImagemService $imagemService
    )
    {
        parent::__construct($repository);
        $this->imagemService = $imagemService;
    }

    public function criarComOuSemImagem(ImagemEmUmCampoCadastrarDTO $dto)
    {
        return DB::Transaction(function () use ($dto) {

            if (is_null($dto->id_imagem)) {
                $dto->id_imagem = $this->cadastrarImagem($dto);
            }

            $dtoCriar = TabelaImagemCampoCadastrarOuAtualizarDTO::fromArray([
                'id_campo'  => $dto->id_campo,
                'id_imagem' => $dto->id_imagem,
            ]);

            return $this->repository->criar($dtoCriar);

        });

    }

    public function substituirImagemEmUmCampo(ImagemEmUmCampoAtualizarDTO $dto)
    {

        return DB::Transaction(function () use ($dto) {

            if (is_null($dto->id_imagem_nova)) {
                $dto->id_imagem_nova = $this->cadastrarImagem($dto);
            }

            $dtoAtualizar = TabelaImagemCampoCadastrarOuAtualizarDTO::fromArray([
                'id_campo' => $dto->id_campo,
                'id_imagem' => $dto->id_imagem_nova,
            ]);

            $this->repository->substituirImagemEmUmCampo($dto->id_campo, $dto->id_imagem, $dtoAtualizar);

        });

    }

    private function cadastrarImagem(ImagemEmUmCampoCadastrarDTO | ImagemEmUmCampoAtualizarDTO $dto )
    {
            $nomeSemExtensao = pathinfo(
                $dto->imagem->getClientOriginalName(),
                PATHINFO_FILENAME
            );

            $imagemCadastrarDTO = ImagemCadastrarDTO::fromArray([
                'imagem' => $dto->imagem,
                'nome'   => $nomeSemExtensao,
                'tipo'   => $dto->imagem->extension()
            ]);

            return $this->imagemService->criarComImagem($imagemCadastrarDTO)->id_imagem;
    }
}
