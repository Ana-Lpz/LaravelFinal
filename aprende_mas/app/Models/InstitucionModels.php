<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class InstitucionModels extends Model
{
    use HasFactory;

    protected $table = "institucion"; 
    
    public $timestamps = false; 

    protected $fillable = [  
        "nombre_inst",
        "tipo_institucion",
        "estado_institucion",
        "id_municipio",
    ];

    protected $primaryKey = "id_institucion";
}
