<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NuevoAlumnoRequest extends FormRequest
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
            "nombre_registro" => array(
                "required", "string"
            ),
            "apellido_registro" => array(
                "required", "string"
            ),
            "nie" => array(
                'regex:/\d{6}[0-8]/'
            ),
            "id_grado" => array(
                "required", "integer"
            ),
            "id_institucion" => array(
                "required", "integer"
            ),
            "fecha_nacimiento" => array(
                "required"
            ),
            "genero" => array(
                "required", "string"
            ),
            "id_municipio" => array(
                "required", "integer"
            ),
        ];
    }

    public function messages() 
    {
        return array(
            "nombre_registro.required" => "Se requiere un nombre",
            "apellido_registro.required" => "Se requiere un apellido",
            "nie.regex" => "Se requiere un nie de 8 digitos",
            "id_grado.required" => "El grado es requerido",
            "id_institucion.required" => "La institucion es requerida",
            "fecha_nacimiento.required" => "La fecha de nacimiento es requerida",
            "genero.required" => "El genero es requerido",
            "id_municipio.required" => "La direccion es requerida",
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
