<?php

namespace App\Models\Funcionario;

use App\Models\BaseModel\BaseModel;

class FuncionarioListaInfo extends BaseModel
{
    protected $table = 'funcionario_listainfo';

    protected $primaryKey = 'idfuncionario_listainfo';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = [
        'descricao',
    ]; 

    public function outrasInfo()
    {
        return $this->hasMany(FuncionarioOutrasInfo::class, 'funcionario_listainfo_idfuncionario_listainfo');
    }

}
