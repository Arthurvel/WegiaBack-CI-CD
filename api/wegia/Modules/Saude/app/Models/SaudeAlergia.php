<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;

class SaudeAlergia extends BaseModel
{
    protected $table = 'saude_alergia';

    protected $primaryKey = 'id_alergia';

    protected $fillable = [
        'nome'
    ];

    public function fichaMedica()
    {
        return $this->belongsToMany(
            SaudeFichaMedica::class,
            'saude_fichamedica_alergia',
            'id_alergia',
            'id_fichamedica'
        );
    }
}
