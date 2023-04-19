<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NuevoAdministradorRequest extends FormRequest
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
            "correo" => array(
                'regex: /^(([^<>()\[\]\.,;:\s@\”]+(\.[^<>()\[\]\.,;:\s@\”]+)*)|(\”.+\”))@(([^<>()[\]\.,;:\s@\”]+\.)+[^<>()[\]\.,;:\s@\”]{2,})$/'
            ),
            "contra" => array(
                "required", "string"
            ),
            "repetir_contra" => array(
                "required", "string"
            ),
        ];
    }

    
    public function messages() 
    {
        return array(
            "nombre_registro.required" => "Se requiere un nombre",
            "apellido_registro.required" => "Se requiere un apellido",
            "correo.regex" => "Se requiere un correo electrónico",
            "contra.required" => "Se requiere una contraseña",
            "repetir_contra.required" => "Se requiere repetir la contraseña",
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
