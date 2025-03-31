<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;

class FuncionarioQuadroHorario extends BaseModel
{
    protected $table = 'quadro_horario_funcionario';

    protected $primaryKey = 'id_quadro_horario';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'id_funcionario',
        'escala',
        'tipo',
        'carga_horaria',
        'entrada1',
        'saida1',
        'entrada2',
        'saida2',
        'total',
        'dias_trabalhados',
        'folga'
    ]; 

    public function quadroHorarioTipo()
    {
        return $this->hasOne(FuncionarioQuadroHorarioTipo::class, 'id_tipo', 'tipo');
    }

    public function quadroHorarioEscala()
    {
        return $this->hasOne(FuncionarioQuadroHorarioEscala::class, 'id_escala', 'escala');
    }
}
