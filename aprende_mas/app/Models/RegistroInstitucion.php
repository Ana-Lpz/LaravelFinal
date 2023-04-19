<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroInstitucion extends Model
{
    use HasFactory;

    protected $table = "registro_institucion"; 
    
    public $timestamps = false; 

    protected $fillable = [  
       'id_registro',
       'id_institucion',
    ];

    protected $primaryKey = "id_registro_institucion";
}
