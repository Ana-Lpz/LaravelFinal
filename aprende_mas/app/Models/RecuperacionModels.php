<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecuperacionModels extends Model
{
    use HasFactory;

    protected $table = "recuperacion";
    
    public $timestamps = false; 

    protected $fillable = [  
       'correo_recuperacion',
       'id_registro',
    ];

    protected $primaryKey = "id_recuperacion";
}
