<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator; 
use Illuminate\Validation\ValidationException; 

class NuevaInstitucionRequest extends FormRequest
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
            "nombre_inst" => array(
                "required", "string"
            ),
            "tipo_institucion" => array(
                "required", "string"
            ),
            "id_municipio" => array(
                "required", "integer", "min:1", "max:7"
            ),
        ];
    }

    public function messages() 
    {
        return array(
            "nombre_inst.required" => "Se requiere un nombre para la institucion",
            "tipo_institucion.required" => "El tipo de institucion es requerido",
            "id_municipio.required" => "Se requiere una direccion para la institucion",
            "id_municipio.integer" => "La direccion debe ser un número del 1 al 7",
            "id_municipio.min" => "Debe ingresar un número mayor o igual que 1",
            "id_municipio.max" => "Debe ingresar un número menor o igual que 7",
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
