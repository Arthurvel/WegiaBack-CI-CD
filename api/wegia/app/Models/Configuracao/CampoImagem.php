<?php

namespace app\Models\Configuracao;

use App\Models\BaseModel\BaseModel;

class CampoImagem extends BaseModel
{

    protected $table = 'campo_imagem';

    protected $primaryKey = 'id_campo';

    protected $fillable = [
        'nome_campo',
        'tipo'
    ];

    public function imagens()
    {
        return $this->belongsToMany(
            Imagem::class,
            TabelaImagemCampo::class,
            'id_campo',
            'id_imagem'
        );
    }

}


