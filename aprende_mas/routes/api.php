<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\RegistroController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\InsigniaController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\UsuarioController;

use App\Http\Controllers\AutenticacionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Rutas de controlador Autenticación
Route::post("/auth/registro1", [AutenticacionController::class, "registro1"]);
Route::post("/auth/registro2", [AutenticacionController::class, "registro2"]);
Route::post("/auth/iniciar-sesion1", [AutenticacionController::class, "iniciarSesion1"]);
Route::post("/auth/iniciar-sesion2", [AutenticacionController::class, "iniciarSesion2"]);

#Rutas protegidas
Route::middleware(['auth:api'])->group(function () { 
    Route::get("/auth/perfil1", [AutenticacionController::class, "perfil1"]); 
    Route::get("/auth/perfil2", [AutenticacionController::class, "perfil2"]); 
    Route::get("/auth/cerrar-sesion", [AutenticacionController::class, "cerrarSesion"]); 
});


//Rutas de controlador institución
Route::get("/institucion-listar", [InstitucionController::class, "listar"]);
Route::get("/institucion-obtener/{id}", [InstitucionController::class, "obtener"]);
Route::post("/institucion-insertar", [InstitucionController::class, "insertar"]);
Route::post("/institucion-actualizar/{id}", [InstitucionController::class, "actualizar"]);
Route::post("/institucion-eliminar/{id}", [InstitucionController::class, "eliminar"]);


//Rutas de controlador Registro (Alumnos = 1 y Administradores = 2)
Route::get("/registro-listar1", [RegistroController::class, "listar1"]);
Route::get("/registro-listar2", [RegistroController::class, "listar2"]);
Route::get("/registro-obtener1/{id}", [RegistroController::class, "obtener1"]);
Route::get("/registro-obtener2/{id}", [RegistroController::class, "obtener2"]);
Route::post("/registro-insertar1", [RegistroController::class, "insertar1"]);
Route::post("/registro-insertar2", [RegistroController::class, "insertar2"]);
Route::post("/registro-actualizar1/{id}", [RegistroController::class, "actualizar1"]);
Route::post("/registro-actualizar2/{id}", [RegistroController::class, "actualizar2"]);
Route::post("/registro-eliminar1/{id}", [RegistroController::class, "eliminar1"]);
Route::post("/registro-eliminar2/{id}", [RegistroController::class, "eliminar2"]);


//Rutas de controlador Grado
Route::get("/grado-listar", [GradoController::class, "listar"]);
Route::get("/grado-obtener/{id}", [GradoController::class, "obtener"]);
Route::post("/grado-insertar", [GradoController::class, "insertar"]);
Route::post("/grado-actualizar/{id}", [GradoController::class, "actualizar"]);
Route::post("/grado-eliminar/{id}", [GradoController::class, "eliminar"]);


//Rutas de controlador Materia
Route::get("/materia-listar1", [MateriaController::class, "listar1"]);
Route::get("/materia-listar2", [MateriaController::class, "listar2"]);
Route::get("/materia-obtener/{id}", [MateriaController::class, "obtener"]);
Route::post("/materia-insertar", [MateriaController::class, "insertar"]);
Route::post("/materia-actualizar/{id}", [MateriaController::class, "actualizar"]);
Route::post("/materia-eliminar/{id}", [MateriaController::class, "eliminar"]);


//Rutas de controlador unidades
Route::get("/unidad-listar1", [UnidadController::class, "listar1"]);
Route::get("/unidad-listar2", [UnidadController::class, "listar2"]);
Route::get("/unidad-obtener/{id}", [UnidadController::class, "obtener"]);
Route::post("/unidad-insertar", [UnidadController::class, "insertar"]);
Route::post("/unidad-actualizar/{id}", [UnidadController::class, "actualizar"]);
Route::post("/unidad-eliminar/{id}", [UnidadController::class, "eliminar"]);


//Rutas de controlador cuestionario
Route::get("/tema-listar1", [TemaController::class, "listar1"]);
Route::get("/tema-listar2", [TemaController::class, "listar2"]);
Route::get("/tema-obtener/{id}", [TemaController::class, "obtener"]);
Route::post("/tema-insertar", [TemaController::class, "insertar"]);
Route::post("/tema-actualizar/{id}", [TemaController::class, "actualizar"]);
Route::post("/tema-eliminar/{id}", [TemaController::class, "eliminar"]);


//Rutas de controlador encuesta
Route::get("/encuesta-listar", [EncuestaController::class, "listar"]);
Route::get("/encuesta-obtener/{id}", [EncuestaController::class, "obtener"]);
Route::post("/encuesta-insertar", [EncuestaController::class, "insertar"]);
Route::post("/encuesta-actualizar/{id}", [EncuestaController::class, "actualizar"]);
Route::post("/encuesta-eliminar/{id}", [EncuestaController::class, "eliminar"]);


//Rutas de controlador de pregunta
Route::post("/pregunta-insertar", [PreguntaController::class, "insertar"]);







