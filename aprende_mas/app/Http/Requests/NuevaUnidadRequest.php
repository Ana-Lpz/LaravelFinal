<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NuevaUnidadRequest extends FormRequest
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
            "nombre_unidad" => array(
                "required", "string"
            ),
            "estado_unidad" => array(
                "required", "integer"
            ),
            "id_materia" => array(
                "required", "integer"
            ),
            "id_grado" => array(
                "required", "integer"
            ),
        ];
    }

    public function messages() 
    {
        return array(
            "nombre_unidad.required" => "Se requiere un nombre para la unidad",
            "estado_unidad.required" => "Se requiere asignar un estado",
            "estado_unidad.integer" => "El estado puede ser 0 = inactivo ó 1 = activo",
            "id_materia.required" => "La materia es requerida",
            "id_grado.required" => "El grado es requerido",
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
