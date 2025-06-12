<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_especie';
    
    protected $primaryKey = 'id_pet_especie';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['descricao'];

    
}
