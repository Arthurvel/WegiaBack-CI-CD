<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especie extends BaseModel
{
    use HasFactory;

    protected $fillable = ['nome'];
}
