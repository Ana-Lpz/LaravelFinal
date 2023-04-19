<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NuevaMateriaRequest extends FormRequest
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
            "nombre_materia" => array(
                "required", "string"
            ),
            "nivel_academico" => array(
                "required", "integer",
            ),
            "estado_materia" => array(
                "required", "integer",
            ),
        ];
    }

    public function messages() 
    {
        return array(
            "nombre_materia.required" => "Se requiere asignar un nombre a la materia",
            "nivel_academico.required" => "Se requiere asignar un grado",
            "estado_materia.required" => "Se requiere asignar un estado",
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
