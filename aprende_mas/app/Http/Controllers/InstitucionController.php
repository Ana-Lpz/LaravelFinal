<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Tablas involucradas: institucion, municipio, departamento
use DateTime;
use App\Models\InstitucionModels;
use App\Models\MunicipioModels;
use App\Models\Departamento; 
use App\Http\Requests\NuevaInstitucionRequest;


class InstitucionController extends Controller
{
    public function listar(Request $request)
    {
        $institucion = InstitucionModels::all();

        $institucion = DB::table('institucion') 
        ->join('municipio', 'institucion.id_municipio', '=', 'municipio.id_municipio') 
        ->join('departamento', 'municipio.id_departamento', '=', 'departamento.id_departamento') 
        ->select("institucion.id_institucion","institucion.nombre_inst","institucion.tipo_institucion", "municipio.nombre_municipio","departamento.nombre_departamento", "estado_institucion") 
        ->orderby("institucion.id_institucion", "asc")
        ->get();


        for ($i=0; $i < count($institucion); $i++) 
        { 
            if ($institucion[$i]->estado_institucion == 1) {
                $institucion[$i]->estado_institucion= "activo";
            }
            else {
                $institucion[$i]->estado_institucion = "inactivo";
            }
        }


        return response()->json($institucion); 
    }
    //--------------------------------------------------------------------------------------------
    public function obtener(Request $request, $id)
    {
        $institucion = DB::table('institucion') 
        
        ->where("institucion.id_institucion", "=", $id)
        ->join('municipio', 'institucion.id_municipio', '=', 'municipio.id_municipio') 
        ->join('departamento', 'municipio.id_departamento', '=', 'departamento.id_departamento') 
        ->select("institucion.id_institucion","institucion.nombre_inst","institucion.tipo_institucion", "municipio.nombre_municipio","departamento.nombre_departamento", "estado_institucion") 
        ->first();

  
        if ($institucion == null) {
            $mensaje = array("error" => "La institucion no fue encontrada"); 

            return response()->json($mensaje, 404);
        }


        if ($institucion->estado_institucion == 1) {
            $institucion->estado_institucion= "activo";
        }
        else {
            $institucion->estado_institucion = "inactivo";
        }
        

        return response()->json($institucion);
    }
//--------------------------------------------------------------------------------------------
    public function insertar(NuevaInstitucionRequest $request)
    {
        $request->validated();

        
        $datos = array(
            "nombre_inst" => $request->nombre_inst,
            "tipo_institucion" => $request->tipo_institucion,
            "id_municipio" => $request->id_municipio,

            "estado_institucion" => 1,
        );

        $nuevaInstitucion = new InstitucionModels($datos);
        $nuevaInstitucion->save();

        return response()->json($nuevaInstitucion);
    }
//--------------------------------------------------------------------------------------------
    public function actualizar(Request $request, $id)
    {
        $institucion=InstitucionModels::where("id_institucion", $id)->first();
        $institucion->nombre_inst = $request->nombre_inst;
        $institucion->save();

        

        return response()->json($institucion);
    }
//--------------------------------------------------------------------------------------------
    public function eliminar(Request $request, $id) 
    {
        $institucion = InstitucionModels::where("id_institucion", $id)->first();

        if($institucion == null){
            $mensaje = array(
                "error"=> "Institucion no encontrada."
            );

            return response()->json($mensaje, 404);
        }

        $institucion->estado_institucion = 0;
        $institucion->save();
        $borrado = array(
            "Exito"=> "La institucion fue borrada exitosamente"
        );

        return response()->json($borrado);
    }
}
