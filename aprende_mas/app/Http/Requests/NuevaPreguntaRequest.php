<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;


class NuevaPreguntaRequest extends FormRequest
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
            "id_materia" => array(
                "required", "integer",
            ),
            "id_tema" => array(
                "required", "integer",
            ),
            "pregunta" => array(
                "required", "string",
            ),
            "puntaje" => array(
                "required", "numeric",
            ),
            "opcion1" => array(
                "required", "string",
            ),
            "opcion2" => array(
                "required", "string",
            ),
        ];
    }

    public function messages() 
    {
        return array(
            "id_materia.required" => "Se requiere escoger una materia",
            "id_tema.required" => "Se requiere escoger un cuestionario",
            "pregunta.required" => "Se requiere escribir una pregunta",
            "puntaje.required" => "Se requiere indicar el puntaje de la pregunta",
            "opcion1.required" => "Se requiere una respuesta",
            "opcion2.required" => "Se requiere otra respuesta",
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
