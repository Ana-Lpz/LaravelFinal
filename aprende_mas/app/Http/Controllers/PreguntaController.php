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

        $nuevaRelacion = new Respuesta([
            "opcion1" => $request->opcion1,
            "opcion2" => $request->opcion2,
            "opcion3" => $request->opcion3,
            "opcion4" => $request->puntaje,
        ]);
        $nuevaRelacion->save();

        return response()->json($nuevaPregunta);
    }
}
