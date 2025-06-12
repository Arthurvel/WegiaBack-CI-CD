<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Raca extends BaseModel
{
    use HasFactory;

    protected $table = 'pet_raca';
    
    protected $primaryKey = 'id_pet_raca';

    public $incrementing = true;

    public $timestamps = false;

    protected $fillable = ['descricao'];

    
}
