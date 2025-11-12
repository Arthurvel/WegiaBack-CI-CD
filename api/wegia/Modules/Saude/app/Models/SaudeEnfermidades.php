<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaudeEnfermidades extends BaseModel
{

    protected $table = 'saude_enfermidades';

    protected $primaryKey = 'id_enfermidade';

    protected $fillable = [
        'id_fichamedica',
        'id_CID',
        'data_diagnostico',
        'status'
    ];

    public function cid() : BelongsTo
    {
        return $this->belongsTo(SaudeCID::class, 'id_CID');
    }

}
