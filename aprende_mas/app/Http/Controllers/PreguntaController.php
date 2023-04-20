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
    public function insertar(NuevaPreguntaRequest $request) 
    {
        $request->validated();

        $datos = array(
            "id_materia" => $request->id_materia,
            "id_tema" => $request->id_tema,
            "pregunta" => $request->pregunta,
            "puntaje" => $request->puntaje,

            "estado_pregunta" => 1,
        );

        $nuevaPregunta = new PreguntaModels($datos);
        $nuevaPregunta->save();

        $respuesta = new Respuesta([
            "opcion1" => $request->opcion1,
            "opcion2" => $request->opcion2,
            "opcion3" => $request->opcion3,
            "opcion4" => $request->opcion4,
            "respuesta_correcta" => $request->respuesta_correcta,
            "id_pregunta" => $request->id_pregunta,
        ]);
        $respuesta->save();

        return response()->json([
            "pregunta" => $nuevaPregunta , 
            "respuesta 1" => $respuesta->opcion1,
            "respuesta 2" => $respuesta->opcion2,
            "respuesta 3" => $respuesta->opcion3,
            "respuesta 4" => $respuesta->opcion4,
        ],200);
    }
}
