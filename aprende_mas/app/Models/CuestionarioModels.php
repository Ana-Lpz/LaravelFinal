<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuestionarioModels extends Model
{
    use HasFactory;

    protected $table = "cuestionario";
    
    public $timestamps = false; 

    protected $fillable = [  
       'inicio_cuestionario',
       'final_cuestionario',
       'nota_final',
       'duracion_cuestionario',
       'intento',
       'estado_cuestoinario',
       'estado',
       'id_grado', 
       'id_progreso',
       'id_tema',
       'id_registro',
       'id_unidad',

    ];

    protected $primaryKey = "id_cuestionario";
}
