<?php

namespace App\Http\Controllers;
use App\Models\MunicipioModels;
use App\Models\RegistroModels;
use App\Models\InstitucionModels;
use App\Models\GradoModels;
use App\Models\MateriaModels;

use Illuminate\Http\Request;

class ReporteController extends Controller{

    public function listar(Request $request) 
    {
        
        $municipio = MunicipioModels::whereNot("id_municipio", null)
        ->select("municipio.id_municipio","nombre_municipio","municipio.id_departamento")
        ->get();

        return response()->json($municipio); 
    }

    public function listar2(Request $request) 
    {
        $registro = RegistroModels::whereNot("id_registro", null)
        ->select("registro.id_registro","nombre_registro","registro.nombre_registro","registro.apellido_registro","registro.fecha_registro")
        ->get();

        return response()->json($registro); 
    }

    public function listar3(Request $request) 
    {
        
        $institucion = InstitucionModels::whereNot("id_institucion", null)
        ->select("institucion.id_institucion","nombre_inst","institucion.id_municipio")
        ->get();

        return response()->json($institucion); 
    }

    public function listar4(Request $request) 
    {
        
        $institucion = InstitucionModels::whereNot("id_institucion", null)
        ->where("tipo_institucion", "Publico")
        ->select("institucion.id_institucion","nombre_inst","institucion.id_municipio","institucion.tipo_institucion")
        ->get();

        return response()->json($institucion); 
    }

    public function listar5(Request $request) 
    {
        
        $institucion = InstitucionModels::whereNot("id_institucion", null)
        ->where("tipo_institucion", "Privado")
        ->select("institucion.id_institucion","nombre_inst","institucion.id_municipio","institucion.tipo_institucion")
        ->get();

        return response()->json($institucion); 
    }

    public function listar6(Request $request) 
    {
        $registro1 = RegistroModels::whereNot("id_registro", null)
        ->select("registro.id_registro","registro.nombre_registro","registro.apellido_registro","registro.fecha_registro","registro.genero","registro.id_grado","registro.id_municipio")
        ->get();

        return response()->json($registro1); 
    }

    public function listar7(Request $request) 
    {
        $grado = GradoModels::whereNot("id_grado", null)
        ->select("grado.id_grado","nivel_academico")
        ->get();

        return response()->json($grado); 
    }

    public function listar8(Request $request) 
    {
        $materia = MateriaModels::whereNot("id_materia", null)
        ->select("materia.id_materia","nombre_materia")
        ->get();

        return response()->json($materia); 
    }
}
