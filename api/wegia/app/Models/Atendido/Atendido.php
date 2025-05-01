<?php

namespace App\Models\Atendido;

use App\Models\BaseModel\BaseModel;
use App\Models\Pessoa;

class Atendido extends BaseModel
{
    protected $table = 'atendido';

    protected $primaryKey = 'idatendido';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'pessoa_id_pessoa',
        'atendido_tipo_idatendido_tipo',
        'atendido_status_idatendido_status'
    ]; 


    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'pessoa_id_pessoa', 'id_pessoa');
    }

    public function atendidoTipo()
    {
        return $this->belongsTo(AtendidoTipo::class, 'atendido_tipo_idatendido_tipo', 'idatendido_tipo');
    }
    
    public function atendidoStatus()
    {
        return $this->belongsTo(AtendidoStatus::class, 'atendido_status_idatendido_status', 'idatendido_status');
    }
}
