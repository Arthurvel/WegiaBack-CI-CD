<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;

class SaudeExameTipos extends BaseModel
{

    protected $table = 'saude_exame_tipos';

    protected $primaryKey = 'id_exame_tipo';

    protected $fillable = [
        'descricao'
    ];
}
