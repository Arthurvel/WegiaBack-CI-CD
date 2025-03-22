<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;

class FuncionarioQuadroHorarioEscala extends BaseModel
{
    protected $table = 'escala_quadro_horario';

    protected $primaryKey = 'id_escala';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'descricao',
    ]; 

    public function quadroHorario()
    {
        return $this->belongsTo(FuncionarioQuadroHorario::class, 'escala');
    }
}
