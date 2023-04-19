<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemaModels extends Model
{
    use HasFactory;

    protected $table = "tema"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'titulo',
       'estado_tema',
       'id_materia',
    ];

    protected $primaryKey = "id_tema";
}
