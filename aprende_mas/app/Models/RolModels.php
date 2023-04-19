<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolModels extends Model
{
    use HasFactory;

    protected $table = "rol"; 
    
    public $timestamps = false; 

    protected $fillable = [ 
       'tipo_rol',
    ];

    protected $primaryKey = "id_rol";
}
