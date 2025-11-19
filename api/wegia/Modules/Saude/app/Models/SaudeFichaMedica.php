<?php

namespace Modules\Saude\app\Models;

use App\Models\BaseModel\BaseModel;
use App\Models\Pessoa\Pessoa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaudeFichaMedica extends BaseModel
{

    protected $table = 'saude_fichamedica';

    protected $primaryKey = 'id_fichamedica';

    protected $fillable = [
        'id_pessoa',
        'prontuario'
    ];

    public function pessoa() : BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_pessoa');
    }

    public function historico() : HasMany
    {
        return $this->hasMany(SaudeFichaMedicaProntuarioHistorico::class, 'id_fichamedica')->orderBy('data', 'desc');
    }


}
