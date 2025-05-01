<?php

namespace App\Models\Atendido;

use App\Models\BaseModel\BaseModel;

class AtendidoStatus extends BaseModel
{
    protected $table = 'atendido_status';

    protected $primaryKey = 'idatendido_status';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'status'
    ]; 
}
