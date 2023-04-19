<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;
    

    protected $table = "unidad"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'nombre_unidad',
       'estado_unidad',
       'id_materia',
    ];

    protected $primaryKey = "id_unidad";
}
