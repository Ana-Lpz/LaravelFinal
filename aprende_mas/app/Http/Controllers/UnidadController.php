<?php

namespace App\Http\Controllers;

use App\Http\Requests\NuevaUnidadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Tablas involucradas: unidad, materia, cuestionario, grado
use DateTime;
use App\Models\Unidad; 
use App\Models\MateriaModels;
use App\Models\CuestionarioModels; 
use App\Models\GradoModels; 



class UnidadController extends Controller
{
    public function listar1(Request $request) //Vista de alumno
    {//Salen más resultados de los que deberían en Postman, pedir ayuda
        $unidad = Unidad::whereNotNull("unidad.id_unidad");

        $unidad = DB::table('unidad')
        ->join('materia', 'unidad.id_materia', '=', 'materia.id_materia')
        ->join('tema', 'tema.id_materia', '=', 'materia.id_materia') 
        ->select("unidad.nombre_unidad","tema.titulo") 
        ->get();


        return response()->json($unidad); 
    }
    //--------------------------------------------------------------------------------------------
    public function listar2(Request $request) //Vista de administador
    {
        $unidad = Unidad::all();

        $unidad = DB::table('unidad')
        ->join('materia', 'unidad.id_materia', '=', 'materia.id_materia')
        //->join('cuestionario', 'cuestionario.id_unidad', '=', 'unidad.id_unidad') 
        //Falta agregar el #cuestionarios
        ->select("unidad.id_unidad","unidad.nombre_unidad","materia.nombre_materia","unidad.estado_unidad") 
        ->get();


        for ($i=0; $i < count($unidad); $i++) 
        { 
            if ($unidad[$i]->estado_unidad == 1) {
                $unidad[$i]->estado_unidad= "activo";
            }
            else {
                $unidad[$i]->estado_unidad= "inactivo";
            }
        }


        return response()->json($unidad); 
    }
    //--------------------------------------------------------------------------------------------
    public function obtener(Request $request, $id)
    {
        $unidad = Unidad::where("unidad.id_unidad", "=", $id)
        ->join('materia', 'unidad.id_materia', '=', 'materia.id_materia')
        //->join('cuestionario', 'cuestionario.id_unidad', '=', 'unidad.id_unidad') 
        //Falta agregar el #cuestionarios
        ->select("unidad.id_unidad","unidad.nombre_unidad","materia.nombre_materia","unidad.estado_unidad") 
        ->first();


        if ($unidad == null) {
            $mensaje = array("error" => "La unidad seleccionada no fue encontrada"); 

            return response()->json($mensaje, 404);
        }


       if ($unidad->estado_unidad  == 1) {
            $unidad->estado_unidad = "activo";
        }
        else {
            $unidad->estado_unidad  = "inactivo";
        }
        

        return response()->json($unidad);
    }
//--------------------------------------------------------------------------------------------
   public function insertar(NuevaUnidadRequest $request)//Se tiene que poder agregar grado, pero no se muestra ni tampoco da error
    {
        $unidad = DB::table('unidad')
        ->join('materia', 'unidad.id_materia', '=', 'materia.id_materia')
        ->join('cuestionario', 'cuestionario.id_unidad', '=', 'unidad.id_unidad') 
        ->join('grado', 'cuestionario.id_grado', '=', 'grado.id_grado')
        ->select("grado.nivel_academico")
        ->get();

        $request->validated();

        $datos = array(
            "nombre_unidad" => $request->nombre_unidad,
            "estado_unidad" => $request->estado_unidad,
            "id_materia" => $request->id_materia,
            "id_grado" => $request->id_materia,
        );


        $nuevaUnidad = new Unidad($datos);
        $nuevaUnidad->save();


        if ($nuevaUnidad->estado_unidad == 1) {
            $nuevaUnidad->estado_unidad = "Activo";
        }
        else {
            $nuevaUnidad->estado_unidad = "Inactivo";
        }

        return response()->json($nuevaUnidad);
    }
//--------------------------------------------------------------------------------------------
    public function actualizar(Request $request, $id) //Preguntar si es necesario agregar lo de convertir los 1 y 0 a la palabra activo o inactivo
    {
        $unidad=Unidad::where("id_unidad", $id)->first();
        $unidad->nombre_unidad = $request->nombre_unidad;
        $unidad->save();

        return response()->json($unidad);
    }
    //------------------------------------------
    public function eliminar(Request $request, $id) 
    {
        $unidad = Unidad::where("id_unidad", $id)->first();

        if($unidad == null){
            $mensaje = array(
                "error"=> "unidad no encontrada."
            );

            return response()->json($mensaje, 404);
        }

        $unidad->estado_unidad = 0;
        $unidad->save();
        $borrado = array(
            "Exito"=> "La unidad fue borrada exitosamente"
        );

        return response()->json($borrado);
    }
}
