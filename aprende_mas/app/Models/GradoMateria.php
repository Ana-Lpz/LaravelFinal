<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradoMateria extends Model
{
    //////
    use HasFactory;

    protected $table = "grado_materia"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'id_grado',
       'id_materia',
    ];

    protected $primaryKey = "id_grado_materia";
}
