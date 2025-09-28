<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Funcionario\Funcionario;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaudeMedicamentoAdministracao extends BaseModel
{

    protected $table = 'saude_medicamento_administracao';

    protected $primaryKey = 'idsaude_medicamento_administracao';

    protected $fillable = [
        'aplicacao',
        'saude_medicacao_id_medicacao',
        'funcionario_id_funcionario'
    ];

    public function funcionario() : BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id_funcionario', 'id_funcionario');
    }

}
