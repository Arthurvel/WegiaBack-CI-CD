<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Funcionario\Funcionario;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaudeSinaisVitais extends BaseModel
{

    protected $table = 'saude_sinais_vitais';

    protected $primaryKey = 'id_sinais_vitais';

    protected $fillable = [
        'id_fichamedica',
        'id_funcionario',
        'data',
        'saturacao',
        'pressao_arterial',
        'frequencia_cardiaca',
        'frequencia_respiratoria',
        'temperatura',
        'hgt'
    ];

    protected $casts = [
        'saturacao' => 'float',
        'temperatura' => 'float',
        'hgt' => 'float',
    ];

    public function funcionario() : BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }


}

