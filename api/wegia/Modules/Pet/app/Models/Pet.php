<?php

namespace Modules\Pet\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pet extends BaseModel
{

    protected $table = 'pet';

    protected $primaryKey = 'id_pet';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'data_acolhimento',
        'sexo',
        'caracteristicas_especificas',
        'id_pet_foto',
        'id_pet_especie',
        'id_pet_raca',
        'cor',
    ];

    public function especie() : BelongsTo
    {
        return $this->belongsTo(Especie::class, 'id_pet_especie');
    }

    public function raca() : BelongsTo
    {
        return $this->belongsTo(Raca::class, 'id_pet_raca');
    }

    public function foto() : BelongsTo
    {
        return $this->BelongsTo(PetFoto::class, 'id_pet_foto');
    }

    public function fichaMedica() : HasOne
    {
        return $this->hasOne(FichaMedica::class, 'id_pet');
    }

    public function adocao() : HasOne
    {
        return $this->hasOne(Adocao::class, 'id_pet');
    }
}
