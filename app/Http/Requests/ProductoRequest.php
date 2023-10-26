<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:250',
            'precio' => ['required', 'regex:/^(\d{1,13}|\d{1,13}\.\d{1,2}|\d{1,13},\d{1,2})$/'],
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
            'nombre.max' => 'El campo nombre no debe tener más de :max caracteres.',
            'descripcion.required' => 'El campo descripción es obligatorio.',
            'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
            'descripcion.max' => 'El campo descripción no debe tener más de :max caracteres.',
            'precio.required' => 'El campo precio es obligatorio.',
            'precio.regex' => 'El campo precio debe ser un número válido con hasta dos decimales.',
            'categoria_id.required' => 'El campo categoría es obligatorio.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'imagen.image' => 'El archivo adjunto debe ser una imagen.',
            'imagen.mimes' => 'El archivo adjunto debe ser de tipo jpeg, png, jpg o gif.',
            'imagen.max' => 'El archivo adjunto no debe superar :max kilobytes.',
        ];
    }
}
