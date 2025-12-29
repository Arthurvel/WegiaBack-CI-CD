<?php

namespace Modules\ContribuicaoSocios\app\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Pessoa\Pessoa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Socio extends BaseModel
{

    protected $table = 'socio';

    protected $primaryKey = 'id_socio';

    protected $fillable = [
        'id_pessoa',
        'id_sociostatus',
        'id_sociotipo',
        'id_sociotag',
        'email',
        'valor_periodo',
        'data_referencia'
    ];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

    public function socioStatus(): BelongsTo
    {
        return $this->belongsTo(SocioStatus::class, 'id_sociostatus');
    }

    public function socioTipo(): BelongsTo
    {
        return $this->belongsTo(SocioTipo::class, 'id_sociotipo');
    }

    public function socioTag(): BelongsTo
    {
        return $this->belongsTo(SocioTag::class, 'id_sociotag');
    }

}
