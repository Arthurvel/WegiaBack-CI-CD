<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Funcionario\Funcionario;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaudeIntercorrencia extends BaseModel
{

    protected $table = 'saude_intercorrencia';

    protected $primaryKey = 'id_intercorrencia';

    protected $fillable = [
        'data',
        'descricao',
        'id_funcionario',
        'id_fichamedica'
    ];

    public function funcionario() : BelongsTo
    {
        return $this->belongsTo(Funcionario::class, 'id_funcionario');
    }
}
