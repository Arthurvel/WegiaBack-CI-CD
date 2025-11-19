<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaudeMedicacao extends BaseModel
{
    protected $table = 'saude_medicacao';

    protected $primaryKey = 'id_medicacao';

    protected $fillable = [
        'id_atendimento',
        'medicamento',
        'dosagem',
        'horario',
        'duracao',
        'status'
    ];

    public function atendimento() : BelongsTo
    {
        return $this->belongsTo(SaudeAtendimento::class, 'id_atendimento', 'id_atendimento');
    }

    public function administracao() : HasMany
    {
        return $this->hasMany(SaudeMedicamentoAdministracao::class, 'saude_medicacao_id_medicacao', 'id_medicacao');
    }
}
