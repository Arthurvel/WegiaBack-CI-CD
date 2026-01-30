<?php

namespace app\Models\Configuracao;

use App\Models\BaseModel\BaseModel;

class Imagem extends BaseModel
{

    protected $table = 'imagem';

    protected $primaryKey = 'id_imagem';

    protected $fillable = [
        'nome',
        'imagem',
        'tipo'
    ];

    public function campos()
    {
        return $this->belongsToMany(
            CampoImagem::class,
            TabelaImagemCampo::class,
            'id_imagem',
            'id_campo'
        );
    }

}
