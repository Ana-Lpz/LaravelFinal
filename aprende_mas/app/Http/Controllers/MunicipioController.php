<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Tablas involucradas: municipio, departamento
use DateTime;
use App\Models\MunicipioModels; 
use App\Models\DepartamentoModels;

class MunicipioController extends Controller
{
    public function listar(Request $request)
    {
        $municipio = DB::table('municipio') 
        ->join('departamento', 'municipio.id_departamento', '=', 'departamento.id_departamento') 
        ->select("municipio.nombre_municipio", "departamento.nombre_departamento")
        ->get();

        return response()->json($municipio); 
    }
}
