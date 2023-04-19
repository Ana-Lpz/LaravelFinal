<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $table = "respuesta"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'opcion1',
       'opcion2',
       'opcion3',
       'opcion4',
       'respuesta_correcta',
       'id_pregunta',
    ];

    protected $primaryKey = "id_respuesta";
}
