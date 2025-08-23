<?php

namespace Modules\Pet\app\Models;

use App\Models\BaseModel\BaseModel;

class PetFoto extends BaseModel
{

    protected $table = 'pet_foto';

    protected $primaryKey = 'id_pet_foto';

    protected $fillable = [
        'arquivo_foto_pet',
        'arquivo_foto_pet_nome',
        'arquivo_foto_pet_extensao'
    ];

}
