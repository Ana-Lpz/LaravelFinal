<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipioModels extends Model
{
    use HasFactory;

    protected $table = "municipio"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'nombre_municipio',
       'id_departamento',
    ];

    protected $primaryKey = "id_municipio";
}
