<?php

namespace App\Models\Atendido;

use App\Models\BaseModel\BaseModel;

class OcorrenciaDoc extends BaseModel
{
    protected $table = 'atendido_ocorrencia_doc';

    protected $primaryKey = 'idatendido_ocorrencia_doc';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'atentido_ocorrencia_idatentido_ocorrencias',
        'data',
        'arquivo_nome',
        'arquivo_extensao',
        'arquivo',
    ]; 

    public function ocorrencia()
    {
        return $this->hasOne(Ocorrencia::class, 'idatendido_ocorrencias', 'atentido_ocorrencia_idatentido_ocorrencias');
    }

}
