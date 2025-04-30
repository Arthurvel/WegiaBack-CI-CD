<?php

namespace App\Models\Pet;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FichaMedica extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_ficha_medica';
    
    protected $primaryKey = 'id_ficha_medica';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['id_pet','castrado', 'necessidades_especiais'];
    
    
}
