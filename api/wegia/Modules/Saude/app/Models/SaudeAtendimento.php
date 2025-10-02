<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Funcionario\Funcionario;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SaudeAtendimento extends BaseModel
{
    protected $table = 'saude_atendimento';

    protected $primaryKey = 'id_atendimento';

    protected $fillable = [
        'id_fichamedica',
        'id_funcionario',
        'id_medico',
        'data_registro',
        'data_atendimento',
        'descricao'
    ];

    public function medicacoes() : HasMany
    {
        return $this->hasMany(SaudeMedicacao::class, 'id_atendimento', 'id_atendimento');
    }

    public function medico() : HasOne
    {
        return $this->hasOne(SaudeMedico::class, 'id_medico', 'id_medico');
    }

    public function funcionario() : HasOne
    {
        return $this->hasOne(Funcionario::class, 'id_funcionario', 'id_funcionario');
    }
}
