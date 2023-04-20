<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; 
use App\Models\GradoModels; 
use App\Models\RegistroModels; 
use App\Models\MunicipioModels; 
use App\Models\InstitucionModels; 
use App\Models\RegistroInstitucion; 
use DateTime;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Response; 

class AutenticacionController extends Controller
{
    public function registro1(Request $request) //Registro de usuario
    {
        //$imagen = $request->file('foto');
        //$extension = $imagen->extension();
        //$nombreImagen = Str::slug($request->usuario) . "." . $extension;


        $data = array(
            'nombre_registro' => $request->nombre_registro,
            'apellido_registro' => $request->apellido_registro,
            'nie' => $request->nie,
            //'foto' => $nombreImagen,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
            'password_confirmed' => bcrypt($request->password_confirmed),

            "fecha_registro" => (new DateTime())->format("Y-m-d"),
            "estado_registro" => 1
        );


       //$imagen->storeAs('fotos-perfil/', $nombreImagen);


        $nuevoAlumno = new RegistroModels($data);
        $nuevoAlumno->save();

        $mensaje = array( 
            'mensaje' => "Usuario registrado correctamente"
        );

        return response()->json($mensaje);
    }
//-------------------------------------------------------------------------------------------- 
    public function registro2(Request $request) //Registro de administrador
    {
        //$imagen = $request->file('foto');
        //$extension = $imagen->extension();
        //$nombreImagen = Str::slug($request->usuario) . "." . $extension;


        $data = array( 
            'nombre_registro' => $request->nombre_registro,
            'apellido_registro' => $request->apellido_registro,
        //    'foto' => $nombreImagen,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
            'password_confirmed' => bcrypt($request->password_confirmed),

            "fecha_registro" => (new DateTime())->format("Y-m-d"),
            'estado_registro' => 1,
        );


        //$imagen->storeAs('fotos-perfil/', $nombreImagen);


        $nuevoAdmnistrador = new RegistroModels($data);
        $nuevoAdmnistrador->save();

        $mensaje = array( 
            'mensaje' => "Usuario registrado correctamente"
        );

        return response()->json($mensaje);
    }
//--------------------------------------------------------------------------------------------
    public function iniciarSesion1(Request $request,) //Iniciar sesión para usuario
    {
     
        $credenciales = request(['nie', 'password']);

        if (Auth::attempt($credenciales) == false)
        {
        $mensaje = array(
            'mensaje' => "Verifique sus credenciales"
        );

        return response()->json($mensaje, 401);
        }

        $usuario = $request->user();

        $generarToken = $usuario->createToken('Student Access Token');
    

        $token = $generarToken->token;
        $token->save(); 
    
        $respuesta = array(
            'token_acceso' => $generarToken->accessToken,
            'tipo_token' => 'Bearer',
            'fecha_expiracion' => $generarToken->token->expires_at,
        );

        return response()->json($respuesta);
    }
//--------------------------------------------------------------------------------------------
    public function iniciarSesion2(Request $request) // Iniciar sesión para administrador
    {
        $credenciales = request(['email', 'password']);

        if (Auth::attempt($credenciales) == false)
        {
        $mensaje = array(
            'mensaje' => "Verifique sus credenciales"
        );

        return response()->json($mensaje, 401);
        }

        $usuario = $request->user();

        $generarToken = $usuario->createToken('Admin Access Token');
    

        $token = $generarToken->token;
        $token->save(); 
    
        $respuesta = array(
            'token_acceso' => $generarToken->accessToken,
            'tipo_token' => 'Bearer',
            'fecha_expiracion' => $generarToken->token->expires_at,
        );

        return response()->json($respuesta);
    }
//--------------------------------------------------------------------------------------------
    public function perfil1(Request $request) //Perfil de alumno
    {
        $informacion = $request->user(); 
        $informacion->departamento = MunicipioModels::where('id_municipio', $informacion->id_municipio)
                                    ->select('id_departamento')
                                    ->first();

        $informacion->institucion = RegistroInstitucion::where('id_registro', $informacion->id_registro)
                                    ->select('id_institucion')
                                    ->first();

        return response()->json($informacion);
    }
//--------------------------------------------------------------------------------------------
    public function perfil2(Request $request) //Perfil de administrador
    {
        $informacion = $request->user();

        return response()->json($informacion);
    }
//--------------------------------------------------------------------------------------------
    public function cerrarSesion(Request $request) 
    {
        $informacion = $request->user();  

        $informacion->token()->revoke(); 

        $mensaje = array(
            'mensaje' => "Cierre de sesión exitoso"
        );

        return response()->json($mensaje);
    }
//--------------------------------------------------------------------------------------------
    public function verFotoPerfil($nombreImagen)
    {
        $ruta = storage_path('app/fotos-perfil/' . $nombreImagen);


        if (file_exists($ruta) == false) {
            abort(404); 
        }


        $imagen = File::get($ruta);
        $tipo = File::mimeType($ruta);


        $respuesta = Response::make($imagen, 200);
        $respuesta->header("Content-Type", $tipo);

        return $respuesta;
    }
}