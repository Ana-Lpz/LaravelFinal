<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Tablas involucradas: pregunta, materia, tema cuestionario, respuesta
use DateTime;
use App\Models\PreguntaModels;
use App\Models\MateriaModels;
use App\Models\TemaModels;
use App\Models\CuestionarioModels;
use App\Models\Respuesta;

use App\Http\Requests\NuevaPreguntaRequest;

class PreguntaController extends Controller
{
    public function insertar(NuevaPreguntaRequest $request) //No muestra los datos de la tabla respuesta
    {
        $tema = DB::table('pregunta')
        ->join('materia', 'pregunta.id_materia', '=', 'materia.id_materia')
        ->join('tema', 'pregunta.id_tema', '=', 'tema.id_tema')
        ->join('respuesta', 'pregunta.id_pregunta', '=', 'respuesta.id_pregunta')
        ->select("materia.nombre_materia", "tema.titulo", "pregunta.pregunta", "pregunta.puntaje", "respuesta.opcion1","respuesta.opcion2","respuesta.opcion3","respuesta.opcion4",)
        ->get();

        $request->validated();

        $datos = array(
            "id_materia" => $request->id_materia,
            "id_tema" => $request->id_tema,
            "pregunta" => $request->pregunta,
            "puntaje" => $request->puntaje,
            "opcion1" => $request->opcion1,
            "opcion2" => $request->opcion2,
            "opcion3" => $request->opcion3,
            "opcion4" => $request->puntaje,

            "estado_pregunta" => 1,
        );


        $nuevaPregunta = new PreguntaModels($datos);
        $nuevaPregunta->save();


        return response()->json($nuevaPregunta);
    }
    /*public function listar(Request $request) //Administración de usuario
    {
        $pregunta = PreguntaModels::where("pregunta.estado_pregunta", "=", 1) //Condición
        ->select("pregunta.puntaje_obtenido", "pregunta.estado_pregunta") //Campos a mostrar
        ->join("cuestionario", "pregunta.id_cuestionario", "=", "cuestionario.id_cuestionario"); //relación usuario con pregunta
        $pregunta = $pregunta->get();

        
        for ($i=0; $i < count($pregunta); $i++) //Sustituir 1 y 0 por "activa" e "inactivo"
        { 
            if ($pregunta[$i]->estado_pregunta == 1) {
                $pregunta[$i]->estado_pregunta= "activo";
            }
            else {
                $pregunta[$i]->estado_pregunta = "inactivo";
            }
        }

        return response()->json($pregunta); //mostrar datos en pantalla
    }*/
}
