<?php

namespace App\Models\Atendido;

use App\Models\BaseModel\BaseModel;

class OcorrenciaTipos extends BaseModel
{
    protected $table = 'atendido_ocorrencia_tipos';

    protected $primaryKey = 'idatendido_ocorrencia_tipos';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'descricao',
    ]; 

    public function ocorrencias() 
    {
        return $this->hasMany(Ocorrencia::class, 'atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos', 'idatendido_ocorrencia_tipos');
    }
}
