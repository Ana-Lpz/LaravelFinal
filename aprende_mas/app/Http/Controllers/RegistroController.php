<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Tablas involucradas: usuario, registro, grado, municipio, departamento, rol, registro_institucion, institucion
use DateTime;
use App\Models\UsuarioModels; 
use App\Models\RegistroModels;
use App\Models\RegistroInstitucion;
use App\Models\InstitucionModels;
use App\Models\GradoModels; 
use App\Models\MunicipioModels; 
use App\Models\Departamento;
use App\Models\RolModels;

use App\Http\Requests\NuevoAlumnoRequest;
use App\Http\Requests\NuevoAdministradorRequest;

class RegistroController extends Controller
{
//--------------------------------------------------------------------------------------------
    public function listar1(Request $request) //Listar de alumno
    {
        $alumno = RegistroModels::where("registro.id_rol", "=", 1);
        
        $alumno = DB::table('registro') 
        ->join("registro_institucion", 'registro.id_registro', '=', 'registro_institucion.id_registro') 
        ->join('institucion', 'registro_institucion.id_institucion', '=', 'institucion.id_institucion') 
        ->join('grado', 'registro.id_grado', '=', 'grado.id_grado') 
        ->select("registro.foto", "registro.nombre_registro", "registro.apellido_registro", "registro.nie", "registro.correo","institucion.nombre_inst","grado.nivel_academico", "registro.estado_registro")
        ->get();

        for ($i=0; $i < count($alumno); $i++) 
        { 
            if ($alumno[$i]->estado_registro == 1) {
                $alumno[$i]->estado_registro= "activo";
            }
            else {
                $alumno[$i]->estado_registro = "inactivo";
            }
        }

        return response()->json($alumno); 
    }
//--------------------------------------------------------------------------------------------
    public function listar2(Request $request) //Listar de administrador
    {
        $administrador = RegistroModels::where("registro.id_rol", "=", 2)
        ->select("registro.foto", "registro.nombre_registro", "registro.apellido_registro", "registro.correo","usuario.visita","usuario.sesiones", "registro.estado_registro")
        ->join('usuario', 'registro.id_usuario', '=', 'usuario.id_usuario');
        $administrador = $administrador->get();

        
        for ($i=0; $i < count($administrador); $i++) 
        { 
            if ($administrador[$i]->estado_registro == 1) {
                $administrador[$i]->estado_registro= "activo";
            }
            else {
                $administrador[$i]->estado_registro = "inactivo";
            }
        }

        return response()->json($administrador); 
    }
//--------------------------------------------------------------------------------------------
    public function obtener1(Request $request, $id) //Obtener de alumno
    {
        $alumno = DB::table('registro') 
        
        ->where("registro.id_registro", "=", $id)
        ->where("registro.id_rol", "=", 1)
        ->join("registro_institucion", 'registro.id_registro', '=', 'registro_institucion.id_registro') 
        ->join('institucion', 'registro_institucion.id_institucion', '=', 'institucion.id_institucion') 
        ->join('grado', 'registro.id_grado', '=', 'grado.id_grado') 
        ->select("registro.foto","registro.nombre_registro","registro.apellido_registro", "registro.nie", "registro.correo","institucion.nombre_inst","grado.nivel_academico", "registro.estado_registro")
        ->first();


        if ($alumno == null) {
            $mensaje = array("error" => "El registro no fue encontrado"); 

            return response()->json($mensaje, 404);
        }


        if ($alumno->estado_registro == 1) {
            $alumno->estado_registro= "activo";
        }
        else {
            $alumno->estado_registro = "inactivo";
        }
        

        return response()->json($alumno);
    }
//--------------------------------------------------------------------------------------------
    public function obtener2(Request $request, $id) //Obtener de administrador
    {
        $administrador = DB::table('registro') 
        
        ->where("registro.id_registro", "=", $id)
        ->where("registro.id_rol", "=", 2)
        ->join('usuario', 'registro.id_usuario', '=', 'usuario.id_usuario')
        ->select("registro.foto", "registro.nombre_registro", "registro.apellido_registro", "registro.correo","usuario.visita","usuario.sesiones", "registro.estado_registro")
        ->first();


        if ($administrador == null) {
            $mensaje = array("error" => "El registro no fue encontrado"); 

            return response()->json($mensaje, 404);
        }


        if ($administrador->estado_registro == 1) {
            $administrador->estado_registro= "activo";
        }
        else {
            $administrador->estado_registro = "inactivo";
        }
        

        return response()->json($administrador);
    }
//--------------------------------------------------------------------------------------------
    public function insertar1(NuevoAlumnoRequest $request) //Insertar de alumno
    {
        $request->validated();

        $datos = array(
            "nombre_registro" => $request->nombre_registro,
            "apellido_registro" => $request->apellido_registro,
            "nie" => $request->nie,
            "id_grado" => $request->id_grado,
            "fecha_nacimiento" => $request->fecha_nacimiento,
            "genero" => $request->genero,
            "id_municipio" => $request->id_municipio,

            "fecha_registro" => (new DateTime())->format("Y-m-d"),
            "estado_registro" => 1
        );

        $nuevoAlumno = new RegistroModels($datos);
        $nuevoAlumno->save();


        $registroInstitucion = new RegistroInstitucion([
            "id_registro" => $request->id_registro,
            "id_institucion" => $request->id_institucion
        ]);
        $registroInstitucion->save();


        return response()->json([
            "alumno" => $nuevoAlumno , 
            "institucion" => $registroInstitucion->id_institucion
        ],200);
    }
//--------------------------------------------------------------------------------------------
    public function insertar2(NuevoAdministradorRequest $request) //Insertar de administrador
    {
        $request->validated();

        $datos = array(
            "nombre_registro" => $request->nombre_registro,
            "apellido_registro" => $request->apellido_registro,
            "email" => $request->email,
            "password" => $request->password,
            "password_confirmed" => $request->password_confirmed,

            "fecha_registro" => (new DateTime())->format("Y-m-d"),
            "estado_registro" => 1
        );

        $nuevoAdministrador = new RegistroModels($datos);
        $nuevoAdministrador->save();

        return response()->json($nuevoAdministrador);
    }
//--------------------------------------------------------------------------------------------
    public function actualizar1(Request $request, $id)
    {
        $alumno=RegistroModels::where("id_registro", $id)->first();
        $alumno->nombre_registro = $request->nombre_registro;
        $alumno->apellido_registro = $request->apellido_registro;
        $alumno->nie = $request->nie;
        $alumno->id_grado = $request->id_grado;
        $alumno->fecha_nacimiento = $request->fecha_nacimiento;
        $alumno->genero = $request->genero;
        $alumno->id_municipio = $request->id_municipio;
        $alumno->save();

        $institucion = RegistroInstitucion::where("id_registro", $id)->first();
        $institucion->id_institucion = $request->id_institucion;

        return response()->json([$alumno, "institucion" => $institucion->id_institucion]);
    }
//--------------------------------------------------------------------------------------------
    public function actualizar2(Request $request, $id)
    {
        $administrador=RegistroModels::where("id_registro", $id)->first();
        $administrador->nombre_registro = $request->nombre_registro;
        $administrador->apellido_registro = $request->apellido_registro;
        $administrador->email = $request->email;
        $administrador->save();

        return response()->json($administrador);
    }
//--------------------------------------------------------------------------------------------   
    public function eliminar1(Request $request, $id)
    {
        $alumno = RegistroModels::where("id_registro", $id)->first();

        if($alumno == null){
            $mensaje = array(
                "error"=> "El alumno no fue encontrado."
            );

            return response()->json($mensaje, 404);
        }

        $alumno->estado_registro = 0;
        $alumno->save();
        $borrado = array(
            "Exito"=> "El registro fue borrado exitosamente"
        );

        return response()->json($borrado);
    }
//--------------------------------------------------------------------------------------------   
    public function eliminar2(Request $request, $id)
    {
        $administrador = RegistroModels::where("id_registro", $id)->first();

        if($administrador == null){
            $mensaje = array(
                "error"=> "El administrador no fue encontrado."
            );

            return response()->json($mensaje, 404);
        }

        $administrador->estado_registro = 0;
        $administrador->save();
        $borrado = array(
            "Exito"=> "El registro fue borrado exitosamente"
        );

        return response()->json($borrado);
    }
}
