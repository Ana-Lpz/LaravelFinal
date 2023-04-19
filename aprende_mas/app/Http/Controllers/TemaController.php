<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;

//Tablas involucradas: tema, cuestionario, materia
use App\Models\TemaModels;
use App\Models\CuestionarioModels;
use App\Models\MateriaModels;
use App\Models\PreguntaModels;
use App\Http\Requests\NuevoCuestionarioRequest;
use App\Models\Unidad;

class TemaController extends Controller
{
    public function listar1(Request $request) //Vista de alumno
    {
        $tema = TemaModels::whereNot("id_tema", null)
        ->select("tema.id_tema","tema.titulo")
        ->get();

        return response()->json($tema); 
    }
    //------------------------------------------------------------
    public function listar2(Request $request) //Vista de administrador
    {
        $tema = TemaModels::whereNot("id_tema", null)
        ->select("tema.id_tema","tema.titulo","tema.estado_tema")
        ->get();

        foreach ($tema as $consulta) {
            $preguntas = PreguntaModels::where('id_tema', $consulta->id_tema)->get();

            $consulta->preguntas = count($preguntas);
        }

        return response()->json($tema); 
    }
    //------------------------------------------------------------
    public function obtener(Request $request, $id) //Vista de administrador, alumno no tiene
    {
        $tema = TemaModels::where("tema.id_tema", "=", $id)
        ->select("tema.id_tema","tema.titulo","tema.estado_tema")
        ->first();

        
        if ($tema == null) {
            $mensaje = array("error" => "El cuestionario no fue encontrado"); 

            return response()->json($mensaje, 404);
        }

        $preguntas = PreguntaModels::where('id_tema', $tema->id_tema)->get();
        $tema->preguntas = count($preguntas);
   
        return response()->json($tema);
    }
    //------------------------------------------------------------
    public function insertar(NuevoCuestionarioRequest $request) //No nos funcionó este método, pedir ayuda
    {
        $request->validated();

        $datos = array(
            "estado_tema" => $request->estado_tema,
            "id_materia" => $request->id_materia,
            "titulo" => $request->titulo,
        );

        $nuevoTema = new TemaModels($datos);
        $nuevoTema->save();

        $temaUnidad = new Unidad([
            "id_unidad" => $request->id_unidad,
            "nombre_unidad" => $request->nombre_unidad,
            "estado_unidad" => 1,
            "id_materia" => $request->id_materia,
            "id_tema" => $request->id_tema,
        ]);
        $temaUnidad->save();


        return response()->json([
            "tema" => $nuevoTema , 
            "nombreUnidad" => $temaUnidad->nombre_unidad
        ],200);
    }
    //------------------------------------------------------------
    public function actualizar(Request $request, $id) //Este tampoco funcionó
    {
        $tema=TemaModels::where("titulo", $id)->first();
        $tema->titulo = $request->titulo;
        $tema->save();

        return response()->json($tema);
    }
    //------------------------------------------------------------
    public function eliminar(Request $request, $id) //Este sí funciona
    {
        $tema = TemaModels::where("id_tema", $id)->first();

        if($tema == null){
            $mensaje = array(
                "error"=> "cuestionario no encontrado."
            );

            return response()->json($mensaje, 404);
        }

        $tema->estado_tema = 0;
        $tema->save();
        $borrado = array(
            "Exito"=> "El cuestionario fue borrado exitosamente"
        );

        return response()->json($borrado);
    
    }
}
