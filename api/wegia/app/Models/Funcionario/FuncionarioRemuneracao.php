<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;

class FuncionarioRemuneracao extends BaseModel
{
    protected $table = 'funcionario_remuneracao';

    protected $primaryKey = 'idfuncionario_remuneracao';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'funcionario_id_funcionario',
        'funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo',
        'valor',
        'inicio',
        'fim',
    ]; 

    public function remuneracaoTipo()
    {
        return $this->belongsTo(FuncionarioRemuneracaoTipo::class, 'funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo');
    }
}
