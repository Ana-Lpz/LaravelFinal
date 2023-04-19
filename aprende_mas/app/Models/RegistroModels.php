<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class RegistroModels extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = "registro"; 
    
    public $timestamps = false; 

    protected $fillable = [ 
        "nombre_registro",
        "apellido_registro",
        "nie",
        "fecha_nacimiento",
        "genero",
        "foto",
        "email",
        "password",
        "password_confirmed",
        "fecha_registro",
        "estado_registro",
        "id_usuario",
        "id_grado",
        "id_municipio",
        "id_rol",
    ];

    protected $primaryKey = "id_registro";
}
