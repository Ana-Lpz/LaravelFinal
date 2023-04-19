<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaModels extends Model
{
    use HasFactory;

    protected $table = "pregunta"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'pregunta',
       'puntaje',
       'estado_pregunta',
       'id_tema',
       'id_materia',
       'id_encuesta',
    ];

    protected $primaryKey = "id_pregunta";
}
