<?php

namespace App\Models\Atendido;

use App\Models\BaseModel\BaseModel;

class Ocorrencia extends BaseModel
{
    protected $table = 'atendido_ocorrencia';

    protected $primaryKey = 'idatendido_ocorrencias';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'atendido_idatendido',
        'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos',
        'funcionario_id_funcionario',
        'data',
        'descricao',
    ]; 

    public function tipos() 
    {
        return $this->hasOne(OcorrenciaTipos::class, 'idatendido_ocorrencia_tipos', 'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos');
    }

    public function documento() 
    {
        return $this->hasOne(OcorrenciaDoc::class, 'atentido_ocorrencia_idatentido_ocorrencias', 'idatendido_ocorrencias');
    }
}
