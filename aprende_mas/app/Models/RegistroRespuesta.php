<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroRespuesta extends Model
{
    use HasFactory;
    
    protected $table = "registro_materia"; 
        
    public $timestamps = false; 
    
    protected $fillable = [  
        'respuesta_alumno',
        'id_registro',
        'id_respuesta',
    ];
    
    protected $primaryKey = "id_registro_respuesta";
}
