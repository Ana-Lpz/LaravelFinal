<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroMateria extends Model
{
    use HasFactory;

    protected $table = "registro_materia"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'id_registro',
       'id_materia',
    ];

    protected $primaryKey = "id_registro_materia";
}
