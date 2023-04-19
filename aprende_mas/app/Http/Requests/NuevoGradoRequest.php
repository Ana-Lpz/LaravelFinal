<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NuevoGradoRequest extends FormRequest
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
            "nivel_academico" => array(
                "required", "string"
            ),
            "estado_grado" => array(
                "required", "integer", "min:0", "max:1"
            ),
        ];
    }

    public function messages() 
    {
        return array(
            "nivel_academico.required" => "Se requiere asignar un grado",
            "estado_grado.required" => "Se requiere asignar un estado",
            "estado_grado.integer" => "El estado puede ser 0 = inactivo ó 1 = activo",
            "estado_grado.min" => "Debe ingresar 0 ó 1 como estado",
            "estado_grado.max" => "Debe ingresar 0 ó 1 como estado",
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
