<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Tablas involucradas: materia, grado, unidad, grado, grado_materia
use DateTime;
use App\Models\MateriaModels; 
use App\Models\GradoModels;
use App\Models\Unidad;
use App\Models\GradoMateria;
use App\Http\Requests\NuevaMateriaRequest;


class MateriaController extends Controller
{
    public function listar1(Request $request) //Vista de alumno
    {
        $materia = MateriaModels::whereNotNull("materia.estado_materia")
        ->select("materia.icono","materia.nombre_materia")
        ->get();
        return response()->json($materia); 
    }
    //--------------------------------------------------------------------------------------------
    public function listar2(Request $request) //Vista de administrador
    {
        $materia = DB::table('materia')
        ->join("grado_materia", 'materia.id_materia', '=', 'grado_materia.id_materia') 
        ->join('grado', 'grado_materia.id_grado', '=', 'grado.id_grado') 
        ->select("materia.id_materia", "materia.nombre_materia","grado.nivel_academico", "materia.estado_materia")
        ->get();

        
        foreach ($materia as $consulta) {
            $unidades = Unidad::where('id_materia', $consulta->id_materia)->get();

            $consulta->unidades = count($unidades);
        }

        return response()->json($materia); 
    }
    //--------------------------------------------------------------------------------------------
    public function obtener(Request $request, $id) //Solo funciona con materias que tengan unidades
    {
        $materia = DB::table('materia') 
        
        ->join("grado_materia", 'materia.id_materia', '=', 'grado_materia.id_materia') 
        ->join('grado', 'grado_materia.id_grado', '=', 'grado.id_grado')
        //Agregar lo del #unidades cuando sepamos cómo hacerlo
        ->join('unidad', 'unidad.id_materia', '=', 'materia.id_materia')
        ->select("materia.id_materia", "materia.nombre_materia", "unidad.nombre_unidad", "grado.nivel_academico", "materia.estado_materia")
        ->first();

        if ($materia == null) {
            $mensaje = array("error" => "La materia no fue encontrada"); 

            return response()->json($mensaje, 404);
        }

        if ($materia->estado_materia == 1) {
            $materia->estado_materia= "activo";
        }
        else {
            $materia->estado_materia = "inactivo";
        }
        

        return response()->json($materia);
    }
    //--------------------------------------------------------------------------------------------
    public function insertar(NuevaMateriaRequest $request) //No se muestra el campo de nivel_academico en postman
    {
        $request->validated();
        
        $datos = array(
            "nombre_materia" => $request->nombre_materia,
            "estado_materia" => $request->estado_materia,
        );

        $nuevaMateria = new MateriaModels($datos);
        $nuevaMateria->save();

        $nuevaRelacion = new GradoMateria([
            'id_grado' => $request->nivel_academico,
            'id_materia' => $nuevaMateria->id_materia,
        ]);
        $nuevaRelacion->save();

    
        return response()->json($nuevaMateria);
    }
    //--------------------------------------------------------------------------------------------
    public function actualizar(Request $request, $id)
    {
        $materia=MateriaModels::where("id_materia", $id)->first();
        $materia->nombre_materia = $request->nombre_materia;
        $materia->save();

        return response()->json($materia);
    }
    //--------------------------------------------------------------------------------------------
    public function eliminar(Request $request, $id)
    {
        $materia = MateriaModels::where("id_materia", $id)->first();

        if($materia == null){
            $mensaje = array(
                "error"=> "materia no encontrada."
            );

            return response()->json($mensaje, 404);
        }

        $materia->estado_materia = 0;
        $materia->save();
        $borrado = array(
            "Exito"=> "La materia fue borrada exitosamente"
        );

        return response()->json($borrado);
    }
}
