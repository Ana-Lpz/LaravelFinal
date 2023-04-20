<?php

namespace App\Http\Controllers;

use Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

use App\Models\RegistroModels;


class PasswordController extends Controller
{
    protected function sendResetLinkResponse(Request $request)
    {
        $usuario = RegistroModels::where('email', $request->email)
        ->where('estado_registro', 1)
        ->first();

        if ($usuario == NULL) {
            $mensaje = array(
                'mensaje' => "El correo electrónico no se encuentra registrado."
            );

            return response()->json($mensaje, 404);
        }

        $input = array( 'email' => $request->email ); 
        $enviar = Password::sendResetLink($input);

        if ($enviar != Password::RESET_LINK_SENT) {
            $mensaje = array(
                'mensaje' => "No se pudo enviar el correo electrónico a esta dirección."
            );

            return response()->json($mensaje, 200);
        }

        $mensaje = array(
            'mensaje' => "Correo enviado con éxito"
        );

        return response()->json($mensaje, 200);
    }
    protected function sendResetResponse(Request $request)
    {
        $input = array(
            'email' => $request->email,
            'token' => $request->token,
            'password' => $request->password,
        );

        $cambio = Password::reset($input, function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();

            event(new PasswordReset($user));
        });

        if ($cambio != Password::PASSWORD_RESET) {
            $mensaje = array(
                'mensaje' => "No se logró realizar su cambio de contraseña."
            );

            return response()->json($mensaje, 400);
        }

        $mensaje = array(
            'mensaje' => "Cambio de contraseña realizado con éxito."
        );

        return response()->json($mensaje);
    }
}