<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

//Tablas involucradas: encuesta, pregunta
use App\Models\EncuestaModels;  
use App\Models\PreguntaModels;
use App\Http\Requests\NuevaEncuestaRequest;

class EncuestaController extends Controller
{
    public function listar(Request $request)
    {
        $encuesta = EncuestaModels::select("encuesta.id_encuesta","encuesta.nombre_encuesta","estado_encuesta");
        $encuesta = $encuesta->get();

        foreach ($encuesta as $consulta) {
            $preguntas = PreguntaModels::where('id_encuesta', $consulta->id_encuesta)->get();

            $consulta->preguntas = count($preguntas);
        }
        
        return response()->json($encuesta);
    }
//--------------------------------------------------------------------------------------------
    public function obtener(Request $request, $id)
    {
        $encuesta = EncuestaModels::where("encuesta.id_encuesta", "=", $id)
        ->select("encuesta.id_encuesta","encuesta.nombre_encuesta","estado_encuesta") 
        ->first();


        if ($encuesta == null) {
            $mensaje = array("error" => "La encuesta seleccionada no fue encontrada"); 

            return response()->json($mensaje, 404);
        }

        $preguntas = PreguntaModels::where('id_encuesta', $encuesta->id_encuesta)->get();
        $encuesta->preguntas = count($preguntas);

        return response()->json($encuesta);
    }
//--------------------------------------------------------------------------------------------
   public function insertar(NuevaEncuestaRequest $request)
    {
        $request->validated();

        $datos = array(
            "nombre_encuesta" => $request->nombre_encuesta,
            "estado_encuesta" => $request->estado_encuesta,
        );


        $nuevaEncuesta = new EncuestaModels($datos);
        $nuevaEncuesta->save();


        if ($nuevaEncuesta->estado_encuesta == 1) {
            $nuevaEncuesta->estado_encuesta = "Activo";
        }
        else {
            $nuevaEncuesta->estado_encuesta = "Inactivo";
        }

        return response()->json($nuevaEncuesta);
    }
//--------------------------------------------------------------------------------------------
    public function actualizar(Request $request, $id) 
    {
        $encuesta=EncuestaModels::where("id_encuesta", $id)->first();
        $encuesta->nombre_encuesta = $request->nombre_encuesta;
        $encuesta->save();

        
        if ($encuesta->estado_encuesta == 1) {
            $encuesta->estado_encuesta = "Activo";
        }
        else {
            $encuesta->estado_encuesta = "Inactivo";
        }

        return response()->json($encuesta);
    }
//--------------------------------------------------------------------------------------------
    public function eliminar(Request $request, $id) 
    {
        $encuesta = EncuestaModels::where("id_encuesta", $id)->first();

        if($encuesta == null){
            $mensaje = array(
                "error"=> "encuesta no encontrada."
            );

            return response()->json($mensaje, 404);
        }

        $encuesta->estado_encuesta = 0;
        $encuesta->save();
        $borrado = array(
            "Exito"=> "La encuesta fue borrada exitosamente"
        );

        return response()->json($borrado);
    
    }
}
