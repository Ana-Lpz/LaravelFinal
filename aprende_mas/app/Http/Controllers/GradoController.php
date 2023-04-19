<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

//Tablas involucradas: grado
use App\Models\GradoModels;  
use App\Http\Requests\NuevoGradoRequest;

class GradoController extends Controller
{
    public function listar(Request $request)
    {
        $grado = GradoModels::all();


        for ($i=0; $i < count($grado); $i++)
        { 
            if ($grado[$i]->estado_grado == 1) {
                $grado[$i]->estado_grado= "activo";
            }
            else {
                $grado[$i]->estado_grado = "inactivo";
            }
        }


        return response()->json($grado);
    }
//--------------------------------------------------------------------------------------------
    public function obtener(Request $request, $id)
    {
        $grado = GradoModels::where("grado.id_grado", "=", $id)
        ->select("grado.id_grado","grado.nivel_academico","grado.estado_grado")
        ->first();


        if ($grado == null) {
            $mensaje = array("error" => "El grado seleccionado no fue encontrado"); 

            return response()->json($mensaje, 404);
        }


       if ($grado->estado_grado == 1) {
            $grado->estado_grado= "activo";
        }
        else {
            $grado->estado_grado = "inactivo";
        }
        

        return response()->json($grado);
    }
//--------------------------------------------------------------------------------------------
   public function insertar(NuevoGradoRequest $request)
    {
        $request->validated();

        $datos = array(
            "nivel_academico" => $request->nivel_academico,
            "estado_grado" => $request->estado_grado,
        );


        $nuevoGrado = new GradoModels($datos);
        $nuevoGrado->save();


        if ($nuevoGrado->estado_grado == 1) {
            $nuevoGrado->estado_grado = "Activo";
        }
        else {
            $nuevoGrado->estado_grado = "Inactivo";
        }

        return response()->json($nuevoGrado);
    }
//--------------------------------------------------------------------------------------------
    public function actualizar(Request $request, $id) 
    {
        $grado=GradoModels::where("id_grado", $id)->first();
        $grado->nivel_academico = $request->nivel_academico;
        $grado->save();

        return response()->json($grado);
    }
//--------------------------------------------------------------------------------------------
    public function eliminar(Request $request, $id) 
    {
        $grado = GradoModels::where("id_grado", $id)->first();

        if($grado == null){
            $mensaje = array(
                "error"=> "grado no encontrado."
            );

            return response()->json($mensaje, 404);
        }

        $grado->estado_grado = 0;
        $grado->save();
        $borrado = array(
            "Exito"=> "El grado fue borrado exitosamente"
        );

        return response()->json($borrado);
    
    }
}
