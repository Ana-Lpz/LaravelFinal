<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsigniaModels extends Model
{
    use HasFactory;

    protected $table = "insignia"; 
    
    public $timestamps = false; 
    
    protected $fillable = [  
       'nombre_insignia',
       'puntos',
       'imagen_insignia',
       'estado_insignia',
       'id_cuestionario',
       'id_nivel',
    ];

    protected $primaryKey = "id_insignia";
}
