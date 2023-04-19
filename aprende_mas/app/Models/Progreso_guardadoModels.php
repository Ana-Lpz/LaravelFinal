<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progreso_guardadoModels extends Model
{
    use HasFactory;

    protected $table = "progreso_guardado"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'entrada',
       'salida',
       'tiempo_permanencia',
    ];

    protected $primaryKey = "id_progreso";
}
