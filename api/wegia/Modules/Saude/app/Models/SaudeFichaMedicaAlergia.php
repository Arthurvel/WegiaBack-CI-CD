<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaudeFichaMedicaAlergia extends BaseModel
{
    protected $table = 'saude_fichamedica_alergia';

    protected $primaryKey = 'id_fichamedica_alergia';

    protected $fillable = [
        'id_fichamedica',
        'id_alergia'
    ];

    public function alergias() : BelongsTo
    {
        return $this->belongsTo(SaudeAlergia::class, 'id_alergia');
    }
}
