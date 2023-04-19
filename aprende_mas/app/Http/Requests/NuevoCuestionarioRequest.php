<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NuevoCuestionarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array 
    {
        return [
            "estado_tema" => array(
                "required", "integer",
            ),
            "id_materia" => array(
                "required", "integer"
            ),
            "nombreUnidad" => array(
                "required", "integer",
            ),
            "titulo" => array(
                "required", "string"
            ),

        ];
    }

    public function messages() 
    {
        return array(
            "estado_tema.required" => "Se requiere ingresar un tipo de estado",
            "id_materia.required" => "Se requiere seleccionar una materia",
            "nombreUnidad.required"=> "Se requiere seleccionar una unidad",
            "ttitulo.required" => "Se requiere un titulo sobre lo que trata el cuestionario",
        );
    }


    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 

        $formato = array(
            "error" => "Algunos datos han fallado", 
            "primer_error" => $errors->first(),
            "detalles" => $errors, 
        );

        $respuesta = response()->json($formato, 422); 

        throw new ValidationException($validator, $respuesta);
    }
}
