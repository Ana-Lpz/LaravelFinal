<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradoModels extends Model
{
    use HasFactory;

    protected $table = "grado"; 
    
    public $timestamps = false; 

    protected $fillable = [ 
       'nivel_academico',
       'estado_grado',
    ];

    protected $primaryKey = "id_grado";
}
