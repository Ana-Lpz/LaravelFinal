<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroInsignia extends Model
{
    use HasFactory;

    protected $table = "registro_insignia"; 
    
    public $timestamps = false; 

    protected $fillable = [
        'puntaje_actual',
       'id_registro',
       'id_insignia',
    ];

    protected $primaryKey = "id_registro_insignia";
}
