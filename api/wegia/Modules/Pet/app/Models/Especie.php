<?php

namespace Modules\Pet\app\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Especie extends BaseModel
{

    use HasFactory;

    protected $table = 'pet_especie';

    protected $primaryKey = 'id_pet_especie';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['descricao'];

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class, 'id_pet_especie');
    }

}
