<?php

namespace App\Models\Atendido;

use App\Models\BaseModel\BaseModel;

class AtendidoTipo extends BaseModel
{
    protected $table = 'atendido_tipo';

    protected $primaryKey = 'idatendido_tipo';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'descricao'
    ]; 
}
