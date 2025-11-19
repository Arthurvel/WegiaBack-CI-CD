<?php

namespace Modules\Memorando\app\Models;

use App\Models\BaseModel\BaseModel;
use app\Models\Pessoa\Pessoa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Despacho extends BaseModel
{
    protected $table = 'despacho';

    protected $primaryKey = 'id_despacho';

    protected $fillable = [
        'id_memorando',
        'id_remetente',
        'id_destinatario',
        'texto',
        'data'
    ];

    public function memorando(): BelongsTo
    {
        return $this->belongsTo(Memorando::class, 'id_memorando', 'id_memorando');
    }

    public function remetente(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_remetente', 'id_pessoa')->select('id_pessoa', 'nome');
    }

    public function destinatario(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class, 'id_destinatario', 'id_pessoa')->select('id_pessoa', 'nome');
    }

    public function anexos(): HasMany
    {
        return $this->hasMany(Anexo::class, 'id_despacho', 'id_despacho');
    }
}
