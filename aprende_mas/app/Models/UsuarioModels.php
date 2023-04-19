<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioModels extends Model
{
    use HasFactory;

    protected $table = "usuario"; 
    
    public $timestamps = false; 

    protected $fillable = [  
        "visita",
        "sesiones",
        "id_progreso",
        "id_rol",
    ];

    protected $primaryKey = "id_usuario";
}
