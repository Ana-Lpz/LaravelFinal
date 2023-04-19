<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncuestaModels extends Model
{
    use HasFactory;

    protected $table = "encuesta"; 
    
    public $timestamps = false; 
    
    protected $fillable = [  
       'nombre_encuesta',
       'comentario',
       'estado_encuesta',
    ];

    protected $primaryKey = "id_encuesta";
}
