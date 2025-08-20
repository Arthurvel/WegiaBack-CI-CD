<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;

class FuncionarioOutrasInfo extends BaseModel
{
    protected $table = 'funcionario_outrasinfo';

    protected $primaryKey = 'idfunncionario_outrasinfo';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'funcionario_id_funcionario',
        'funcionario_listainfo_idfuncionario_listainfo',
        'dado'
    ]; 

    public function listaInfo()
    {
        return $this->belongsTo(FuncionarioListaInfo::class, 'funcionario_listainfo_idfuncionario_listainfo');
    }

}
