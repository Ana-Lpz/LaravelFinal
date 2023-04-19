<?php

namespace App\Http\Controllers;

use App\Http\Requests\NuevaUnidadRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Tablas involucradas: unidad, materia, cuestionario, grado
use DateTime;
use App\Models\Unidad; 
use App\Models\MateriaModels;
use App\Models\TemaModels;
use App\Models\CuestionarioModels; 
use App\Models\GradoModels; 
use App\Models\GradoMateria;



class UnidadController extends Controller
{
    public function listar1(Request $request) //Vista de alumno
    { //Muestra demasiado datos
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
    {//salen demasiado resultados en postman
        $unidad = DB::table('unidad')
        ->join('materia', 'unidad.id_materia', '=', 'materia.id_materia')
        ->join('tema', 'tema.id_materia', '=', 'materia.id_materia')
        ->select("unidad.id_unidad","unidad.nombre_unidad","materia.nombre_materia","unidad.estado_unidad") 
        ->get();

        foreach ($unidad as $consulta) {
            $cuestionarios = TemaModels::where('id_materia', $consulta->id_unidad)->get();

            $consulta->cuestionarios = count($cuestionarios);
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

        return response()->json($unidad);
    }
//--------------------------------------------------------------------------------------------
   public function insertar(NuevaUnidadRequest $request)//Se tiene que poder agregar grado, pero no se muestra ni tampoco da error
    {
        $request->validated();

        $datos = array(
            "nombre_unidad" => $request->nombre_unidad,
            "estado_unidad" => $request->estado_unidad,
            "id_materia" => $request->id_materia,
        );

        $nuevaUnidad = new Unidad($datos);
        $nuevaUnidad->save();


        $nuevaRelacion = new GradoMateria([
            'id_grado' => $request->nivel_academico,
            'id_materia' => $nuevaUnidad->id_materia,
        ]);
        $nuevaRelacion->save();

        return response()->json($nuevaUnidad);
    }
//--------------------------------------------------------------------------------------------
    public function actualizar(Request $request, $id) 
    {
        $unidad=Unidad::where("id_unidad", $id)->first();
        $unidad->nombre_unidad = $request->nombre_unidad;
        $unidad->save();

        $mensaje = array( 
            'mensaje' => "La unidad ha sido actualizada"
        );

        return response()->json($mensaje);
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
