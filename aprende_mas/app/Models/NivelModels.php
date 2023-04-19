<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelModels extends Model
{
    use HasFactory;

    protected $table = "nivel"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'nivel_alumno',
       'puntaje_nivel',
    ];

    protected $primaryKey = "id_nivel";
}
