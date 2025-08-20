<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;

class FuncionarioQuadroHorarioTipo extends BaseModel
{
    protected $table = 'tipo_quadro_horario';

    protected $primaryKey = 'id_tipo';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'descricao',
    ]; 

    public function quadroHorario()
    {
        return $this->belongsTo(FuncionarioQuadroHorario::class, 'tipo');
    }
}
