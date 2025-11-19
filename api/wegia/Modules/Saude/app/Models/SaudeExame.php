<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SaudeExame extends BaseModel
{

    protected $table = 'saude_exames';

    protected $primaryKey = 'id_exame';

    protected $fillable = [
        'id_fichamedica',
        'id_exame_tipo',
        'data',
        'arquivo_nome',
        'arquivo_extensao',
        'arquivo'
    ];

    public function tipo() : HasOne
    {
        return $this->hasOne(SaudeExameTipos::class, 'id_exame_tipo', 'id_exame_tipo');
    }

}
