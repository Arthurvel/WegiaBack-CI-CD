<?php

namespace app\Repositories\Configuracao;

use app\DTOs\Configuracao\TabelaImagemCampoCadastrarOuAtualizarDTO;
use app\Models\Configuracao\TabelaImagemCampo;
use App\Repositories\Base\BaseRepository;

class TabelaImagemCampoRepository extends BaseRepository
{

    public function __construct(
        TabelaImagemCampo $model
    )
    {
        parent::__construct($model);
    }
    public function substituirImagemEmUmCampo(int $id_campo, int $id_imagem, TabelaImagemCampoCadastrarOuAtualizarDTO $dto)
    {
        $relacao = $this->model
            ->where('id_campo', $id_campo)
            ->where('id_imagem', $id_imagem)
            ->firstOrFail();

        $relacao->update([
            'id_imagem' => $dto->id_imagem
        ]);

        return $relacao->fresh();
    }

}
